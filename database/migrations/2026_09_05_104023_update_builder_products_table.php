<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Remove old unique index
        |--------------------------------------------------------------------------
        */

        $indexes = DB::select(
            "SHOW INDEX FROM builder_products WHERE Key_name = 'builder_product_unique'"
        );

        if (!empty($indexes)) {
            Schema::table('builder_products', function (Blueprint $table) {
                $table->dropUnique('builder_product_unique');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | 2. Add product_type if it does not already exist
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('builder_products', 'product_type')) {
            Schema::table('builder_products', function (Blueprint $table) {
                $table->string('product_type')
                    ->nullable()
                    ->after('builder_type_id');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | 3. Set product type for existing records
        |--------------------------------------------------------------------------
        |
        | Existing records don't have a product_type.
        |
        | We use "Other" temporarily so the migration can continue.
        |
        */

        DB::table('builder_products')
            ->whereNull('product_type')
            ->update([
                'product_type' => 'Other',
            ]);


        /*
        |--------------------------------------------------------------------------
        | 4. Make product_type required
        |--------------------------------------------------------------------------
        */

        Schema::table('builder_products', function (Blueprint $table) {
            $table->string('product_type')
                ->nullable(false)
                ->change();
        });


        /*
        |--------------------------------------------------------------------------
        | 5. Drop old foreign keys
        |--------------------------------------------------------------------------
        */

        if (Schema::hasColumn('builder_products', 'builder_brand_id')) {
            try {
                Schema::table('builder_products', function (Blueprint $table) {
                    $table->dropForeign(['builder_brand_id']);
                });
            } catch (\Throwable $e) {
                // Foreign key may already be removed.
            }
        }

        if (Schema::hasColumn('builder_products', 'builder_category_id')) {
            try {
                Schema::table('builder_products', function (Blueprint $table) {
                    $table->dropForeign(['builder_category_id']);
                });
            } catch (\Throwable $e) {
                // Foreign key may already be removed.
            }
        }

        if (Schema::hasColumn('builder_products', 'builder_sub_category_id')) {
            try {
                Schema::table('builder_products', function (Blueprint $table) {
                    $table->dropForeign(['builder_sub_category_id']);
                });
            } catch (\Throwable $e) {
                // Foreign key may already be removed.
            }
        }


        /*
        |--------------------------------------------------------------------------
        | 6. Drop old Builder hierarchy columns
        |--------------------------------------------------------------------------
        */

        $oldColumns = [];

        if (Schema::hasColumn('builder_products', 'builder_brand_id')) {
            $oldColumns[] = 'builder_brand_id';
        }

        if (Schema::hasColumn('builder_products', 'builder_category_id')) {
            $oldColumns[] = 'builder_category_id';
        }

        if (Schema::hasColumn('builder_products', 'builder_sub_category_id')) {
            $oldColumns[] = 'builder_sub_category_id';
        }

        if (!empty($oldColumns)) {
            Schema::table('builder_products', function (Blueprint $table) use ($oldColumns) {
                $table->dropColumn($oldColumns);
            });
        }


        /*
        |--------------------------------------------------------------------------
        | 7. Remove duplicate records
        |--------------------------------------------------------------------------
        |
        | New unique rule:
        |
        | builder_type_id
        | product_type
        | product_id
        |
        | Keep the first record and delete duplicates.
        |
        */

        $duplicates = DB::table('builder_products')
            ->select(
                'builder_type_id',
                'product_type',
                'product_id',
                DB::raw('MIN(id) as keep_id'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(
                'builder_type_id',
                'product_type',
                'product_id'
            )
            ->having('total', '>', 1)
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('builder_products')
                ->where('builder_type_id', $duplicate->builder_type_id)
                ->where('product_type', $duplicate->product_type)
                ->where('product_id', $duplicate->product_id)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
        }


        /*
        |--------------------------------------------------------------------------
        | 8. Add new unique index
        |--------------------------------------------------------------------------
        */

        $newIndexes = DB::select(
            "SHOW INDEX FROM builder_products WHERE Key_name = 'builder_product_unique'"
        );

        if (empty($newIndexes)) {
            Schema::table('builder_products', function (Blueprint $table) {
                $table->unique(
                    [
                        'builder_type_id',
                        'product_type',
                        'product_id',
                    ],
                    'builder_product_unique'
                );
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Remove new unique index
        |--------------------------------------------------------------------------
        */

        $indexes = DB::select(
            "SHOW INDEX FROM builder_products WHERE Key_name = 'builder_product_unique'"
        );

        if (!empty($indexes)) {
            Schema::table('builder_products', function (Blueprint $table) {
                $table->dropUnique('builder_product_unique');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Restore old columns
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('builder_products', 'builder_brand_id')) {
            Schema::table('builder_products', function (Blueprint $table) {
                $table->unsignedBigInteger('builder_brand_id')
                    ->nullable()
                    ->after('builder_type_id');
            });
        }

        if (!Schema::hasColumn('builder_products', 'builder_category_id')) {
            Schema::table('builder_products', function (Blueprint $table) {
                $table->unsignedBigInteger('builder_category_id')
                    ->nullable()
                    ->after('builder_brand_id');
            });
        }

        if (!Schema::hasColumn('builder_products', 'builder_sub_category_id')) {
            Schema::table('builder_products', function (Blueprint $table) {
                $table->unsignedBigInteger('builder_sub_category_id')
                    ->nullable()
                    ->after('builder_category_id');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Remove product_type
        |--------------------------------------------------------------------------
        */

        if (Schema::hasColumn('builder_products', 'product_type')) {
            Schema::table('builder_products', function (Blueprint $table) {
                $table->dropColumn('product_type');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Restore foreign keys
        |--------------------------------------------------------------------------
        */

        Schema::table('builder_products', function (Blueprint $table) {

            $table->foreign('builder_brand_id')
                ->references('id')
                ->on('builder_brands')
                ->nullOnDelete();

            $table->foreign('builder_category_id')
                ->references('id')
                ->on('builder_categories')
                ->nullOnDelete();

            $table->foreign('builder_sub_category_id')
                ->references('id')
                ->on('builder_sub_categories')
                ->nullOnDelete();
        });


        /*
        |--------------------------------------------------------------------------
        | Restore old unique index
        |--------------------------------------------------------------------------
        */

        $indexes = DB::select(
            "SHOW INDEX FROM builder_products WHERE Key_name = 'builder_product_unique'"
        );

        if (empty($indexes)) {
            Schema::table('builder_products', function (Blueprint $table) {
                $table->unique(
                    [
                        'builder_type_id',
                        'product_id',
                    ],
                    'builder_product_unique'
                );
            });
        }
    }
};