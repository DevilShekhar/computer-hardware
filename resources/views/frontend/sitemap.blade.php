<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc>{{ route('home') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <url>
        <loc>{{ route('our-products') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>

    @foreach ($products as $product)
        <url>
            <loc>{{ route('product.details', ['slug' => $product->slug]) }}</loc>
            @if ($product->updated_at)
                <lastmod>{{ $product->updated_at->toAtomString() }}</lastmod>
            @endif
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    <url>
        <loc>{{ route('our-brand') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    @foreach ($brands as $brand)
        <url>
            <loc>{{ route('our-brand.show', ['slug' => $brand->slug]) }}</loc>
            @if ($brand->updated_at)
                <lastmod>{{ $brand->updated_at->toAtomString() }}</lastmod>
            @endif
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    <url>
        <loc>{{ route('pc-builder.index') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    @foreach ($builderTypes as $builderType)
        <url>
            <loc>{{ route('pc-builder.show', ['slug' => $builderType->slug]) }}</loc>
            @if ($builderType->updated_at)
                <lastmod>{{ $builderType->updated_at->toAtomString() }}</lastmod>
            @endif
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    <url>
        <loc>{{ route('compare') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

    <url>
        <loc>{{ route('about-us') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>

    <url>
        <loc>{{ route('privacy-policy') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>

    <url>
        <loc>{{ route('terms-and-conditions') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>

    <url>
        <loc>{{ route('disclaimer') }}</loc>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>

</urlset>