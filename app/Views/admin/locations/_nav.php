<div id="loc-breadcrumbs-container" hx-swap-oob="true">
    <?= view('admin/locations/_breadcrumbs', [
        'active_country' => $active_country ?? null,
        'active_state' => $active_state ?? null
    ]) ?>
</div>
<div class="relative" id="loc-search-container" hx-swap-oob="true">
    <?= view('admin/locations/_search_form', [
        'tab' => $tab ?? 'countries',
        'country_id' => $country_id ?? null,
        'state_id' => $state_id ?? null,
        'search' => $search ?? '',
        'all_countries' => $all_countries ?? []
    ]) ?>
</div>