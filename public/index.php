<?php

require_once dirname(__DIR__) . '/bootstrap.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo Config::get('app.name'); ?></title>
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
            max-width: 800px;
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
        .config-item {
            background: #f9fafb;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-family: monospace;
            font-size: 13px;
        }
        .config-item strong {
            color: #667eea;
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
            width: 20%;
            transition: width 0.3s;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars(Config::get('app.name')); ?></h1>
        
        <div class="status">
            <p><span class="step">✓ Step 1:</span> Folder structure + empty files</p>
            <p><span class="step">✓ Step 2:</span> Config loader + env handling</p>
        </div>

        <div class="progress">
            <div class="progress-bar"></div>
        </div>

        <h3 style="margin: 20px 0 10px; color: #4b5563;">Configuration Status</h3>
        
        <div class="config-item">
            <strong>App Name:</strong> <?php echo htmlspecialchars(Config::get('app.name')); ?>
        </div>
        
        <div class="config-item">
            <strong>App URL:</strong> <?php echo htmlspecialchars(Config::get('app.url')); ?>
        </div>
        
        <div class="config-item">
            <strong>Environment:</strong> <?php echo htmlspecialchars(Config::get('app.env')); ?>
        </div>
        
        <div class="config-item">
            <strong>Debug Mode:</strong> <?php echo Config::get('app.debug') ? 'Enabled' : 'Disabled'; ?>
        </div>
        
        <div class="config-item">
            <strong>Session Name:</strong> <?php echo htmlspecialchars(Config::get('app.session.name')); ?>
        </div>
        
        <div class="config-item">
            <strong>Session Lifetime:</strong> <?php echo Config::get('app.session.lifetime'); ?> seconds
        </div>
        
        <div class="config-item">
            <strong>Timezone:</strong> <?php echo htmlspecialchars(Config::get('app.timezone')); ?>
        </div>
        
        <div class="config-item">
            <strong>Database Host:</strong> <?php echo htmlspecialchars(Config::get('database.host')); ?>
        </div>
        
        <div class="config-item">
            <strong>Database Name:</strong> <?php echo htmlspecialchars(Config::get('database.database')); ?>
        </div>
        
        <div class="config-item">
            <strong>PHP Version:</strong> <?php echo PHP_VERSION; ?>
        </div>
        
        <div class="config-item">
            <strong>Session Status:</strong> <?php echo session_status() === PHP_SESSION_ACTIVE ? 'Active' : 'Inactive'; ?>
        </div>

        <p style="margin-top: 30px; color: #6b7280; font-size: 14px; text-align: center;">
            Core PHP 8+ Custom MVC Framework | Next: Router + Request/Response Classes
        </p>
    </div>
</body>
</html>
