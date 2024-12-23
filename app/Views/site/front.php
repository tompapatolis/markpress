<?= $this->extend('layout_default') ?>
<?= $this->section('main') ?>

<div class="container">
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

<section class="mt-5">
    <h1>Button Size Test</h1>
    <div class="grid grid-center grid-col-auto-175 grid-center gap-1">
        <button class="btn btn-xs btn-accent-800">Extra Small Button</button>
        <button class="btn btn-sm btn-accent-800">Small Button</button>
        <button class="btn btn-md btn-accent-800">Medium Button</button>
        <button class="btn btn-lg btn-accent-800">Large Button</button>
        <button class="btn btn-xl btn-accent-800">Extra Large Button</button>
    </div>

    <h1>Neutral Color Buttons</h1>
    <div class="grid grid-col-auto-150 gap-1 mb-2">
        <button class="btn btn-50">Neutral 50</button>
        <button class="btn btn-100">Neutral 100</button>
        <button class="btn btn-200">Neutral 200</button>
        <button class="btn btn-300">Neutral 300</button>
        <button class="btn btn-400">Neutral 400</button>
        <button class="btn btn-500">Neutral 500</button>
        <button class="btn btn-600">Neutral 600</button>
        <button class="btn btn-700">Neutral 700</button>
        <button class="btn btn-800">Neutral 800</button>
        <button class="btn btn-900">Neutral 900</button>
        <button class="btn btn-1000">Neutral 1000</button>
    </div>

    <h1>Accent Color Buttons</h1>
    <div class="grid grid-col-auto-150 gap-1 mb-2">
        <button class="btn btn-accent-50">Accent 50</button>
        <button class="btn btn-accent-100">Accent 100</button>
        <button class="btn btn-accent-200">Accent 200</button>
        <button class="btn btn-accent-300">Accent 300</button>
        <button class="btn btn-accent-400">Accent 400</button>
        <button class="btn btn-accent-500">Accent 500</button>
        <button class="btn btn-accent-600">Accent 600</button>
        <button class="btn btn-accent-700">Accent 700</button>
        <button class="btn btn-accent-800">Accent 800</button>
        <button class="btn btn-accent-900">Accent 900</button>
        <button class="btn btn-accent-1000">Accent 1000</button>
    </div>

    <h1>Custom Color Buttons</h1>
    <div class="grid grid-col-auto-150 gap-1 mb-2">
        <button class="btn btn-red">Red</button>
        <button class="btn btn-green">Green</button>
        <button class="btn btn-yellow">Yellow</button>
        <button class="btn btn-magenta">Magenta</button>
        <button class="btn btn-crimson">Crimson</button>
        <button class="btn btn-purple">Purple</button>
        <button class="btn btn-orange">Orange</button>
    </div>
</section>

<section class="grid gap-15">
    <form class="display-contents">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" placeholder="Enter your username">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Enter your email">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" placeholder="Enter your password">
        </div>

        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea id="bio" placeholder="Tell us about yourself"></textarea>
        </div>

        <div class="form-actions">
            <label>
                <input type="checkbox"> Remember Me
            </label>
            <button type="submit">Sign In</button>
        </div>

        <div class="form-group">
            <label for="dropdown">Select an Option</label>
            <div class="form-select">
                <select id="dropdown">
                    <option value="disabled selected">Select an option...</option>
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                    <option value="option3">Option 3</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="toggle-dark-mode" class="toggle-description">Dark Mode</label>
            <div class="toggle-switch">
                <input type="checkbox" id="toggle-dark-mode" class="toggle-input">
                <label for="toggle-dark-mode" class="toggle-label">
                    <span class="toggle-circle"></span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="toggle-cache" class="toggle-description">Cache Page</label>
            <div class="toggle-switch">
                <input type="checkbox" id="toggle-cache" class="toggle-input">
                <label for="toggle-cache" class="toggle-label">
                    <span class="toggle-circle"></span>
                </label>
            </div>
        </div>

        <p class="form-error">An error occurred. Please try again.</p>
        <p class="form-success">Form submitted successfully!</p>

    </form>
</section>


<?= $this->endSection() ?>
