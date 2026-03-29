<?= view('web/include/header', ['title' => $title]) ?>
<?php
$adContent = json_decode($ad['ad_content'], true);
$imageUrl = isset($adContent['image_url']) ? base_url($adContent['image_url']) : null;
?>

<div class="flex min-h-screen bg-gray-50 dark:bg-background-dark">
    <?= view('agent/include/sidebar') ?>

    <main class="flex-1 p-6 md:p-10 flex items-center justify-center">
        <div class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

            <!-- Column 1: Ad Preview -->
            <div
                class="bg-white dark:bg-card-dark rounded-3xl border border-gray-100 dark:border-gray-800 shadow-2xl p-8 flex flex-col h-full relative overflow-hidden group">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent pointer-events-none rounded-3xl">
                </div>

                <div class="flex items-center gap-3 mb-8 relative z-10">
                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary">visibility</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold dark:text-white">Ad Preview</h2>
                        <p class="text-sm text-gray-500">Live preview of your placement</p>
                    </div>
                </div>

                <?php if ($imageUrl): ?>
                    <div
                        class="w-full flex-grow flex flex-col border border-gray-100 dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm bg-white dark:bg-card-dark relative z-10">
                        <div
                            class="bg-gray-50 dark:bg-gray-900 px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center shrink-0">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest truncate max-w-[200px]"
                                title="<?= esc($ad['title']) ?>">Campaign: <?= esc($ad['title']) ?></span>
                            <span
                                class="text-xs py-1 px-3 bg-primary/10 text-primary rounded-full capitalize font-semibold shadow-sm"><?= esc($ad['format']) ?></span>
                        </div>
                        <div
                            class="flex-grow p-8 flex items-center justify-center relative bg-[size:24px_24px] bg-[linear-gradient(to_right,#f0f0f0_1px,transparent_1px),linear-gradient(to_bottom,#f0f0f0_1px,transparent_1px)] dark:bg-[linear-gradient(to_right,#2a2a2a_1px,transparent_1px),linear-gradient(to_bottom,#2a2a2a_1px,transparent_1px)]">
                            <div class="absolute inset-0 bg-white/40 dark:bg-black/40 backdrop-blur-[1px]"></div>
                            <img src="<?= esc($imageUrl) ?>" alt="Ad Preview"
                                class="max-h-64 object-contain rounded-lg shadow-lg relative z-10 transition-transform duration-300 group-hover:scale-[1.02]">
                        </div>
                    </div>
                <?php else: ?>
                    <div
                        class="w-full h-48 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700 flex flex-col items-center justify-center relative z-10">
                        <span
                            class="material-symbols-outlined text-4xl text-gray-300 dark:text-gray-600 mb-2">image_not_supported</span>
                        <p class="text-sm text-gray-400">Preview not available</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Column 2: Payment Portal -->
            <div
                class="bg-white dark:bg-card-dark rounded-3xl border border-gray-100 dark:border-gray-800 shadow-2xl p-8 md:p-12 text-center flex flex-col items-center justify-center h-full relative">
                <div
                    class="w-20 h-20 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-6 mx-auto shadow-inner shadow-primary/20">
                    <span class="material-symbols-outlined text-4xl">lock</span>
                </div>

                <h1 class="text-3xl font-black text-gray-900 dark:text-white mb-2">Checkout</h1>
                <p class="text-gray-500 mb-8 max-w-[280px]">Complete your secure payment to activate the <strong
                        class="text-gray-900 dark:text-gray-200"><?= esc($ad['title']) ?></strong> campaign.</p>

                <div
                    class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-6 mb-8 w-full border border-gray-100 dark:border-gray-700 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-full blur-2xl -mr-10 -mt-10">
                    </div>
                    <div class="flex justify-between items-center mb-3 text-left relative z-10">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Ad Placement Fee</span>
                        <span class="font-bold text-gray-800 dark:text-gray-200">₹<?= number_format($price, 2) ?></span>
                    </div>
                    <div
                        class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-700 border-dashed text-left relative z-10">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Duration</span>
                        <span class="font-bold text-gray-800 dark:text-gray-200"><?= esc($ad['total_days']) ?>
                            Days</span>
                    </div>
                    <div class="flex justify-between items-center text-left relative z-10">
                        <span class="font-bold text-gray-900 dark:text-white uppercase tracking-wide text-xs">Total
                            Amount</span>
                        <span
                            class="text-3xl font-black text-primary drop-shadow-sm">₹<?= number_format($price, 2) ?></span>
                    </div>
                </div>

                <button id="pay-button"
                    class="w-full bg-gradient-to-r from-primary to-primary-hover text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/30 hover:shadow-primary/50 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2 group relative overflow-hidden">
                    <div
                        class="absolute inset-0 bg-white/20 translate-y-[100%] group-hover:translate-y-0 transition-transform duration-300 ease-out">
                    </div>
                    <span class="material-symbols-outlined relative z-10 text-[20px]">account_balance_wallet</span>
                    <span class="relative z-10">Pay Now with Razorpay</span>
                </button>

                <div class="mt-8 flex items-center justify-center gap-2 text-xs text-gray-400">
                    <span class="material-symbols-outlined text-[14px]">shield</span>
                    <span>100% Secure Transaction</span>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    const options = {
        "key": "<?= $razorpay_key ?>",
        "amount": "<?= $price * 100 ?>", // Razorpay uses paise/cents
        "currency": "INR",
        "name": "UniHunt Ads",
        "description": "Ad Placement: <?= esc($ad['title']) ?>",
        "image": "<?= base_url('favicon_io/android-chrome-512x512.webp') ?>",
        "order_id": "<?= $razorpay_order_id ?>",
        "handler": function (response) {
            // Submit to verification endpoint
            fetch('<?= base_url('agent/ads/verify-payment') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `ad_id=<?= $ad['tracking_id'] ?>&razorpay_payment_id=${response.razorpay_payment_id}&razorpay_order_id=${response.razorpay_order_id}&razorpay_signature=${response.razorpay_signature}&csrf_test_name=<?= csrf_hash() ?>`
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '<?= base_url('agent/ads') ?>?success=1';
                    }
                });
        },
        "prefill": {
            "name": "<?= session()->get('user_name') ?>",
            "email": "<?= session()->get('user_email') ?>"
        },
        "theme": {
            "color": "#1182c5"
        }
    };
    const rzp1 = new Razorpay(options);
    document.getElementById('pay-button').onclick = function (e) {
        rzp1.open();
        e.preventDefault();
    }
</script>

<?= view('web/include/footer') ?>