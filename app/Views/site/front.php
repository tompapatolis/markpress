<?= $this->extend('layout_default') ?>
<?= $this->section('main') ?>

<div class="container pt-5 pt-sm-2">
    <h1>Markpress App - Real-Time Markdown to HTML Converter</h1>

    <img src="<?=path_gfx().'logo.svg'?>" alt="MarkPress Logo" loading="lazy" class="mb-4">

    <p>
        Welcome to <strong>Markpress</strong>, the ultimate app for converting your Markdown files into dynamic, beautifully rendered HTML in real time.
        Whether you're a developer, writer, or content creator, Markpress empowers you to streamline your workflow and focus on what truly matters—creating content.
    </p>

    <h2>With <strong>Markpress</strong>, you can:</h2>

    <ul>
        <li>Transform Markdown files into responsive, semantic HTML effortlessly.</li>
        <li>Preview your content instantly with real-time rendering.</li>
        <li>Enjoy a seamless, distraction-free experience designed for productivity.</li>
    </ul>

    <p>
        Ready to elevate your Markdown experience? Start converting now and see how Markpress can simplify your content creation process!
    </p>

    <a href="#" class="btn-link">Get Started</a>
    <a href="#" class="btn-link">Learn More</a>

    <blockquote>
        "Markpress has revolutionized the way I work with Markdown. It's fast, intuitive, and incredibly powerful—a must-have tool for anyone creating content."
    </blockquote>

    <pre><code class="language-js">
// This is a JavaScript example
function greet(name) {
    console.log(`Hello, ${name}!`);
}
greet('Markpress');
</code></pre>

</div>

<?= $this->endSection() ?>
