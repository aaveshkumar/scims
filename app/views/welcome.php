<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(Config::get('app.name')); ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 900px;
            width: 90%;
        }
        h1 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 28px;
        }
        .status {
            background: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 15px;
            margin: 15px 0;
        }
        .step {
            color: #10b981;
            font-weight: bold;
        }
        .progress {
            background: #e5e7eb;
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-bar {
            background: linear-gradient(90deg, #667eea, #764ba2);
            height: 100%;
            width: 30%;
            transition: width 0.3s;
        }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .feature {
            background: #f9fafb;
            padding: 15px;
            border-radius: 5px;
            border-left: 3px solid #667eea;
        }
        .feature h3 {
            color: #667eea;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .feature p {
            color: #6b7280;
            font-size: 12px;
        }
        .test-links {
            margin-top: 30px;
            padding: 20px;
            background: #eff6ff;
            border-radius: 5px;
        }
        .test-links h3 {
            color: #1e40af;
            margin-bottom: 10px;
        }
        .test-links a {
            display: inline-block;
            margin: 5px 10px 5px 0;
            padding: 8px 15px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .test-links a:hover {
            background: #5568d3;
        }
        footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo e(Config::get('app.name')); ?></h1>
        
        <div class="status">
            <p><span class="step">✓ Step 1:</span> Folder structure + empty files</p>
            <p><span class="step">✓ Step 2:</span> Config loader + env handling</p>
            <p><span class="step">✓ Step 3:</span> Router + request/response classes</p>
        </div>

        <div class="progress">
            <div class="progress-bar"></div>
        </div>

        <h2 style="margin: 20px 0 10px; color: #4b5563; font-size: 18px;">Router Features Implemented</h2>
        
        <div class="feature-grid">
            <div class="feature">
                <h3>✓ Request Class</h3>
                <p>Handle GET, POST, files, headers, JSON input</p>
            </div>
            <div class="feature">
                <h3>✓ Response Class</h3>
                <p>HTML, JSON, redirects, downloads, views</p>
            </div>
            <div class="feature">
                <h3>✓ Router Class</h3>
                <p>GET/POST/PUT/DELETE routes with middleware</p>
            </div>
            <div class="feature">
                <h3>✓ Dynamic Routes</h3>
                <p>URL parameters: /user/{id}</p>
            </div>
            <div class="feature">
                <h3>✓ Helper Functions</h3>
                <p>request(), response(), view(), redirect()</p>
            </div>
            <div class="feature">
                <h3>✓ Validation</h3>
                <p>Built-in validation with error handling</p>
            </div>
            <div class="feature">
                <h3>✓ CSRF Protection</h3>
                <p>Token-based form security</p>
            </div>
            <div class="feature">
                <h3>✓ File Uploads</h3>
                <p>Secure file upload handling</p>
            </div>
            <div class="feature">
                <h3>✓ Session Flash</h3>
                <p>Flash messages and old input</p>
            </div>
            <div class="feature">
                <h3>✓ Auth Helpers</h3>
                <p>auth(), isAuth(), hasRole()</p>
            </div>
        </div>

        <div class="test-links">
            <h3>Test Routes</h3>
            <a href="/test" target="_blank">JSON Response Test</a>
            <a href="/user/123" target="_blank">Dynamic Route Test</a>
            <a href="/notfound" target="_blank">404 Error Test</a>
        </div>

        <footer>
            Core PHP 8+ Custom MVC Framework<br>
            Next: Base Model + Database Connection
        </footer>
    </div>
</body>
</html>
