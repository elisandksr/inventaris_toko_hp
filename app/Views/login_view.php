<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory Ceria</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            margin: 0; padding: 0; font-family: 'Nunito', sans-serif; 
            background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
            height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 3rem; border-radius: 20px;
            width: 100%; max-width: 400px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
            text-align: center;
            transform: translateY(0); animation: float 6s ease-in-out infinite;
        }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-10px); } 100% { transform: translateY(0px); } }
        
        .brand-icon {
            font-size: 3rem; color: #8b5cf6; margin-bottom: 1rem;
            display: inline-block;
            background: #f3f4f6; padding: 1rem; border-radius: 50%;
        }
        h2 { font-family: 'Fredoka', sans-serif; color: #1e293b; margin-bottom: 0.5rem; font-size: 1.8rem; }
        p { color: #64748b; margin-bottom: 2rem; font-size: 0.95rem; }
        
        .form-group { text-align: left; margin-bottom: 1.2rem; }
        .form-control {
            width: 100%; padding: 0.8rem 1rem; border: 2px solid #e2e8f0; border-radius: 12px;
            font-size: 1rem; transition: 0.3s; box-sizing: border-box;
        }
        .form-control:focus { border-color: #8b5cf6; outline: none; }
        
        .btn-login {
            background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
            color: white; border: none; padding: 0.8rem; border-radius: 50px;
            width: 100%; font-weight: 700; font-size: 1rem; cursor: pointer;
            margin-top: 1rem; box-shadow: 0 10px 15px -3px rgba(139, 92, 246, 0.4);
            transition: 0.3s;
        }
        .btn-login:hover { transform: scale(1.02); box-shadow: 0 15px 20px -5px rgba(139, 92, 246, 0.5); }
        
        .alert { background: #fee2e2; color: #ef4444; padding: 0.8rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem; font-weight: 600; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand-icon"><i class='bx bxs-rocket'></i></div>
        <h2>Admin Login</h2>
        <p>Silakan masuk untuk mengelola gudang ceria!</p>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="post">
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn-login">Mulai Beraktivitas <i class='bx bx-right-arrow-alt'></i></button>
        </form>
    </div>
</body>
</html>
