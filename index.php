<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Inicio de sesión al sistema de timbres automáticos" />
    <title>Timbre Automático - Iniciar Sesión</title>
    <link rel="icon" type="image/x-icon" href="img/campana.webp" />
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />
    
    <style>
        :root {
            --primary-blue: #3498db;
            --secondary-blue: #0e92b8;
            --dark-blue: #1d2f80;
            --white: #ffffff;
            --black: #000000;
            --light-gray: #f8f9fa;
            --dark-gray: #2c3e50;
            --overlay: rgba(29, 47, 128, 0.85);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--secondary-blue) 50%, var(--primary-blue) 100%);
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background elements */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(52, 152, 219, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(14, 146, 184, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(29, 47, 128, 0.1) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
            padding: 2rem 1rem;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 3rem 2rem;
            max-width: 480px;
            width: 100%;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 10px 25px rgba(52, 152, 219, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .logo-icon i {
            font-size: 28px;
            color: var(--white);
        }

        .title {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-blue);
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--dark-blue), var(--secondary-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            color: var(--dark-gray);
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid rgba(52, 152, 219, 0.2);
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 400;
            background: rgba(255, 255, 255, 0.8);
            color: var(--dark-gray);
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--primary-blue);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
            transform: translateY(-2px);
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.1rem;
            color: var(--secondary-blue);
            z-index: 3;
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: var(--white);
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-top: 1rem;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(52, 152, 219, 0.4);
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .error-message {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-top: 1rem;
            border-left: 4px solid #dc3545;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .features {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(52, 152, 219, 0.2);
        }

        .features-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-blue);
            margin-bottom: 1rem;
            text-align: center;
        }

        .features-list {
            list-style: none;
            padding: 0;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }

        .feature-icon {
            width: 20px;
            height: 20px;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-icon i {
            font-size: 10px;
            color: var(--white);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }
            
            .login-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }
            
            .title {
                font-size: 1.75rem;
            }
            
            .subtitle {
                font-size: 0.9rem;
            }
        }

        /* Glass morphism effect enhancement */
        @media (min-width: 769px) {
            .login-card {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(30px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }
            
            .form-input {
                background: rgba(255, 255, 255, 0.9);
            }
            
            .form-input:focus {
                background: var(--white);
            }
        }

        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: var(--white);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <h1 class="title">Timbre Automático</h1>
                <p class="subtitle">
                    Accede al sistema de gestión de timbres con horarios programables y control manual para primaria y secundaria.
                </p>
            </div>

            <form action="login.php" method="POST" id="loginForm">
                <div class="form-group">
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <input 
                        class="form-input" 
                        name="username" 
                        placeholder="Nombre de usuario" 
                        type="text" 
                        required 
                        autocomplete="username"
                    />
                </div>

                <div class="form-group">
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input 
                        class="form-input" 
                        name="password" 
                        placeholder="Contraseña" 
                        type="password" 
                        required 
                        autocomplete="current-password"
                    />
                </div>

                <button type="submit" class="login-btn" id="submitBtn">
                    <span class="btn-text">Iniciar Sesión</span>
                </button>

                <?php if (isset($_GET['error'])): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Usuario o contraseña incorrectos. Por favor, inténtalo de nuevo.</span>
                </div>
                <?php endif; ?>
            </form>

            <div class="features">
                <h3 class="features-title">Características del Sistema</h3>
                <ul class="features-list">
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Horarios preestablecidos modificables</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Control manual disponible</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Gestión para primaria y secundaria</span>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Interfaz intuitiva y moderna</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Enhanced form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const btnText = submitBtn.querySelector('.btn-text');
            
            // Add loading state
            submitBtn.disabled = true;
            btnText.innerHTML = '<div class="loading"></div> Iniciando sesión...';
            
            // Optional: Add a small delay to show the loading animation
            setTimeout(() => {
                // The form will submit naturally
            }, 500);
        });

        // Add focus effects to inputs
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentNode.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentNode.style.transform = 'scale(1)';
            });
        });

        // Add entrance animation delay for elements
        window.addEventListener('load', function() {
            const elements = document.querySelectorAll('.form-group, .features');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.6s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 100 * (index + 1));
            });
        });

        // Keyboard navigation enhancement
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.type !== 'submit') {
                e.preventDefault();
                const form = e.target.closest('form');
                const inputs = Array.from(form.querySelectorAll('input'));
                const currentIndex = inputs.indexOf(e.target);
                const nextInput = inputs[currentIndex + 1];
                
                if (nextInput) {
                    nextInput.focus();
                } else {
                    form.querySelector('button[type="submit"]').click();
                }
            }
        });
    </script>
</body>
</html>
