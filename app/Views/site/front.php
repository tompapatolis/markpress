<?= $this->extend('layout_default') ?>
<?= $this->section('main') ?>

<div class="container pt-5 pt-sm-2">
    <h1 class="mb-2">Markpress App - Real-Time Markdown to HTML Converter</h1>

    <img src="<?=path_gfx().'logo.svg'?>" alt="MarkPress Logo" loading="lazy" class="mb-4">

    <p class="mb-3">
        Welcome to <strong>Markpress</strong>, the ultimate app for converting your Markdown files into dynamic, beautifully rendered HTML in real time.
        Whether you're a developer, writer, or content creator, Markpress empowers you to streamline your workflow and focus on what truly matters—creating content.
    </p>

    <p>
        With <strong>Markpress</strong>, you can:
    </p>
    <ul class="mb-3">
        <li>Transform Markdown files into responsive, semantic HTML effortlessly.</li>
        <li>Preview your content instantly with real-time rendering.</li>
        <li>Enjoy a seamless, distraction-free experience designed for productivity.</li>
    </ul>

    <p>
        Ready to elevate your Markdown experience? Start converting now and see how Markpress can simplify your content creation process!
    </p>

    <a href="<?= base_url('get-started') ?>" class="btn btn-primary mt-3">Get Started</a>
    <a href="<?= base_url('features') ?>" class="btn btn-outline-secondary mt-3">Learn More</a>
</div>

<?= $this->endSection() ?>
