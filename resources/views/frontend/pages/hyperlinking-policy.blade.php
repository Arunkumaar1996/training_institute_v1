@extends('layouts.frontend')

@section('title', 'Hyperlinking Policy')

@section('content')
<x-breadcrumb title="Hyperlinking Policy" :breadcrumbs="['Hyperlinking Policy' => route('page.show', 'hyperlinking-policy')]" />

<section class="py-5 bg-white">
    <div class="container max-w-900 mx-auto">
        <article class="p-4 p-md-5 bg-white rounded-4 shadow-sm">
            <h2 class="fw-bold text-primary mb-3">Hyperlinking Policy</h2>
            <h5 class="fw-bold mt-4 mb-2 text-dark">Links to External Websites:</h5>
            <p class="text-muted leading-relaxed">
                At many places in this website, you may find links to other websites/portals (e.g. social media, schematic software tools, vendor links). These external links have been placed for your convenience. We are not responsible for the contents and reliability of the linked websites.
            </p>

            <h5 class="fw-bold mt-4 mb-2 text-dark">Links to Our Website by Other Websites:</h5>
            <p class="text-muted leading-relaxed">
                Prior permission is not required before hyperlinking to pages hosted on this portal. However, we do not permit our pages to be loaded into frames on your site. The pages must load into a user's full window.
            </p>
        </article>
    </div>
</section>
@endsection
