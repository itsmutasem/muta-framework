<div align="center">

<h1>🚀 Muta Framework</h1>

<p>
A lightweight, secure, and modern <b>PHP MVC Framework</b> built from scratch.
<br>
Designed for <b>learning, rapid prototyping, and small-to-medium web applications</b>.
</p>

</div>

<hr>

<h2>📋 Table of Contents</h2>

<ul>
<li><a href="#about">About</a></li>
<li><a href="#features">Features</a></li>
<li><a href="#architecture">Architecture Overview</a></li>
<li><a href="#structure">Directory Structure</a></li>
<li><a href="#requirements">Requirements</a></li>
<li><a href="#installation">Installation</a></li>
<li><a href="#configuration">Configuration</a></li>
<li><a href="#routing">Routing</a></li>
<li><a href="#controllers">Controllers</a></li>
<li><a href="#models">Models & Database</a></li>
<li><a href="#views">Views & Templating</a></li>
<li><a href="#middleware">Middleware</a></li>
<li><a href="#container">Dependency Injection Container</a></li>
<li><a href="#validation">Validation</a></li>
<li><a href="#security">Security</a></li>
<li><a href="#cli">CLI Commands</a></li>
<li><a href="#migrations">Database Migrations</a></li>
<li><a href="#auth">Authentication Scaffold</a></li>
<li><a href="#errors">Error Handling</a></li>
<li><a href="#lifecycle">Request Lifecycle</a></li>
<li><a href="#contributing">Contributing</a></li>
<li><a href="#license">License</a></li>
</ul>

<hr>

<h2 id="about">📖 About</h2>

<p>
<b>Muta</b> is a handcrafted PHP MVC framework focused on simplicity, security, and clean architecture.
</p>

<p>
It implements core software engineering patterns including:
</p>

<ul>
<li>Front Controller</li>
<li>MVC Architecture</li>
<li>Middleware Pipeline</li>
<li>Dependency Injection</li>
<li>Repository Pattern</li>
</ul>

<p>
The goal of Muta is to help developers understand how frameworks work internally while still providing a solid base for building real-world applications.
</p>

<hr>

<h2 id="features">✨ Features</h2>

<table>
<tr>
<th>Category</th>
<th>Features</th>
</tr>

<tr>
<td>Architecture</td>
<td>MVC Pattern, Front Controller, Dependency Injection Container</td>
</tr>

<tr>
<td>Routing</td>
<td>Dynamic & static routes, route parameters, HTTP method support</td>
</tr>

<tr>
<td>Middleware</td>
<td>Composable middleware pipeline</td>
</tr>

<tr>
<td>Security</td>
<td>CSRF protection, XSS sanitization, rate limiting, prepared statements</td>
</tr>

<tr>
<td>Database</td>
<td>PDO based ORM, Schema builder, migrations</td>
</tr>

<tr>
<td>Validation</td>
<td>Server-side form validation with custom rules</td>
</tr>

<tr>
<td>Templating</td>
<td>Layout based template engine (.muta.php)</td>
</tr>

<tr>
<td>CLI</td>
<td>Artisan-like CLI scaffolding tools</td>
</tr>

<tr>
<td>Authentication</td>
<td>One-command login/signup scaffold</td>
</tr>

<tr>
<td>Error Handling</td>
<td>Environment aware error handling</td>
</tr>

<tr>
<td>Environment</td>
<td>.env configuration support</td>
</tr>

</table>

<hr>

<h2 id="architecture">🏗 Architecture Overview</h2>

<pre>
Client Request
      │
      ▼
.htaccess
      │
      ▼
Front Controller (public/index.php)
      │
      ▼
Bootstrap (autoload, env, config)
      │
      ▼
Router
      │
      ▼
Middleware Pipeline
      │
      ▼
Controller
      │
      ▼
Model
      │
      ▼
View Rendering
      │
      ▼
HTTP Response
</pre>

<h3>Design Patterns Used</h3>

<ul>
<li><b>Front Controller</b> — Single application entry point</li>
<li><b>MVC</b> — Separation of concerns</li>
<li><b>Dependency Injection</b> — Automatic dependency resolution</li>
<li><b>Middleware Pipeline</b> — Request filtering</li>
<li><b>Repository Pattern</b> — Clean database access abstraction</li>
<li><b>Template Views</b> — Layout based rendering</li>
</ul>

<hr>

<h2 id="structure">📁 Directory Structure</h2>

<pre>
muta/
│
├── config/
│   ├── routes.php
│   ├── services.php
│   └── middleware.php
│
├── database/
│   └── migrations/
│
├── public/
│   ├── index.php
│   └── .htaccess
│
├── src/
│   ├── App/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Models/
│   │
│   └── Framework/
│       ├── Router.php
│       ├── Request.php
│       ├── Response.php
│       ├── Container.php
│       ├── Validator.php
│       └── Model.php
│
├── views/
│
├── stubs/
│
├── muta.php
├── composer.json
└── .env
</pre>

<hr>

<h2 id="requirements">📦 Requirements</h2>

<ul>
<li>PHP >= 8.0</li>
<li>Composer</li>
<li>Apache or Nginx</li>
<li>MySQL / MariaDB</li>
</ul>

<hr>

<h2 id="installation">🛠 Installation</h2>

<h3>Clone the Repository</h3>

<pre>
git clone https://github.com/yourusername/muta.git
cd muta
</pre>

<h3>Install Dependencies</h3>

<pre>
composer install
</pre>

<h3>Configure Environment</h3>

<pre>
cp .env.example .env
</pre>

Example `.env`

<pre>
DB_HOST=localhost
DB_NAME=muta_db
DB_USER=root
DB_PASS=

APP_ENV=development
APP_DEBUG=true
</pre>

<h3>Run Migrations</h3>

<pre>
php muta.php migrate
</pre>

<hr>

<h2 id="routing">🛤 Routing</h2>

<pre>
$router->add('/', [
  'controller' => Home::class,
  'action' => 'index'
]);

$router->add('/products/{id}', [
  'controller' => Products::class,
  'action' => 'show'
]);

$router->add('/products', [
  'controller' => Products::class,
  'action' => 'store',
  'method' => 'POST'
]);
</pre>

<hr>

<h2 id="controllers">🎮 Controllers</h2>

Create controller

<pre>
php muta.php make:controller ProductController
</pre>

Example:

<pre>
class Products extends Controller
{
    public function index(Request $request): Response
    {
        $products = $this->product->findAll();

        return $this->view('Products/index.muta.php', [
            'products' => $products
        ]);
    }
}
</pre>

<hr>

<h2 id="models">🗄 Models & Database</h2>

Create model

<pre>
php muta.php make:model Product
</pre>

Example model:

<pre>
class Product extends Model
{
    protected string $table = 'products';
}
</pre>

Built-in CRUD methods:

<ul>
<li>find()</li>
<li>findAll()</li>
<li>create()</li>
<li>update()</li>
<li>delete()</li>
</ul>

<hr>

<h2 id="views">🎨 Views & Templating</h2>

Two view types:

<b>1. Layout Views (.muta.php)</b>

<pre>
views/Products/show.muta.php
</pre>

<b>2. Standalone Views (.php)</b>

Used for emails, error pages, etc.

<hr>

<h2 id="middleware">🔗 Middleware</h2>

Create middleware:

<pre>
php muta.php make:middleware AuthenticateMiddleware
</pre>

Middleware example:

<pre>
public function process(Request $request, RequestHandlerInterface $handler): Response
{
    if (!isset($_SESSION['user_id'])) {
        return new Response(302, '', ['Location' => '/login']);
    }

    return $handler->handle($request);
}
</pre>

<hr>

<h2 id="container">📦 Dependency Injection Container</h2>

Register services:

<pre>
$container->set(Database::class, function () {
    return new Database(
        $_ENV['DB_HOST'],
        $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS']
    );
});
</pre>

Dependencies are automatically resolved in controllers.

<hr>

<h2 id="validation">✅ Validation</h2>

Example:

<pre>
$request->validate([
'name' => ['required','min:3'],
'email' => ['required','email'],
'price' => ['numeric']
]);
</pre>

<hr>

<h2 id="security">🔒 Security</h2>

Muta includes multiple security layers:

<ul>
<li>CSRF Protection</li>
<li>XSS Sanitization</li>
<li>SQL Injection Prevention</li>
<li>Rate Limiting</li>
<li>Server-side Validation</li>
<li>Security Headers</li>
<li>Output Escaping</li>
<li>Secure Error Handling</li>
</ul>

<hr>

<h2 id="cli">🖥 CLI Commands</h2>

<pre>
php muta.php make:controller UserController
php muta.php make:model User
php muta.php make:middleware AuthMiddleware
php muta.php make:migration create_users_table
php muta.php migrate
php muta.php install:auth
</pre>

<hr>

<h2 id="migrations">🗃 Database Migrations</h2>

Create migration:

<pre>
php muta.php make:migration create_products_table
</pre>

Run migrations:

<pre>
php muta.php migrate
</pre>

<hr>

<h2 id="auth">🔑 Authentication Scaffold</h2>

Generate authentication system:

<pre>
php muta.php install:auth
</pre>

This creates:

<ul>
<li>AuthController</li>
<li>User Model</li>
<li>Login View</li>
<li>Signup View</li>
<li>Authentication Middleware</li>
</ul>

<hr>

<h2 id="errors">⚠ Error Handling</h2>

<table>
<tr>
<th>Exception</th>
<th>HTTP Code</th>
</tr>

<tr>
<td>PageNotFoundException</td>
<td>404</td>
</tr>

<tr>
<td>CsrfException</td>
<td>403</td>
</tr>

<tr>
<td>Database Exceptions</td>
<td>500</td>
</tr>

<tr>
<td>Generic Exceptions</td>
<td>500</td>
</tr>

</table>

<hr>

<h2 id="lifecycle">🔄 Request Lifecycle</h2>

<pre>
Client
  ↓
.htaccess
  ↓
public/index.php
  ↓
Bootstrap
  ↓
Router
  ↓
Middleware
  ↓
Controller
  ↓
Model
  ↓
View
  ↓
Response
</pre>

<hr>

<h2 id="contributing">🤝 Contributing</h2>

Steps:

<ol>
<li>Fork the repository</li>
<li>Create a feature branch</li>
<li>Commit your changes</li>
<li>Push to your branch</li>
<li>Open a Pull Request</li>
</ol>

<hr>

<h2 id="license">📄 License</h2>

This project is open source and free to use for personal or commercial applications.

<br><br>

<div align="center">

<b>Muta Framework</b>  
Simple • Secure • Fast

</div>
