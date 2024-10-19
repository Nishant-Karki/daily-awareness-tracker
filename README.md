<h2>Daily Awareness Tracker</h2>

<p>A simple Laravel application to track essential daily stats.</p>
<img width="1206" alt="Screenshot 2024-10-19 at 20 40 33" src="https://github.com/user-attachments/assets/7de7e276-7291-4cdf-817f-bede85bf3700">

<h3>Installation</h3>
<ol>
    <li>Setup <code>.env</code> and update the database credentials.</li>
    <li>Run the migration using the command:
        <pre><code>php artisan migrate</code></pre>
    </li>
    <li>Run the seeders using:
        <pre><code>php artisan db:seed</code></pre>
    </li>
    <li>Finally, run the application:
        <pre><code>php artisan serve</code></pre>
    </li>
</ol>

<h3>Credentials for Test User</h3>
<p>Email: <strong>test@example.com</strong><br>
   Password: <strong>password</strong></p>

<h3>Features</h3>
<ul>
    <li>Login and Registration</li>
    <li>Enter Daily awareness data with quality score</li>
    <li>Analytics of the quality score</li>
    <li>Update and delete the data</li>
    <li>Notification in the navigation bar in case you forget to enter today's data</li>
</ul>
