<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bảo trì hệ thống</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }

        .maintenance-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            padding: 60px 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .maintenance-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 20px rgba(102, 126, 234, 0);
            }
        }

        .maintenance-icon i {
            font-size: 50px;
            color: white;
        }

        .maintenance-title {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 15px;
        }

        .maintenance-subtitle {
            font-size: 18px;
            color: #6c757d;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .maintenance-message {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .maintenance-message p {
            color: #495057;
            margin-bottom: 0;
            font-size: 15px;
            line-height: 1.7;
        }

        .progress-container {
            margin-bottom: 30px;
        }

        .progress-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .progress-label i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .progress {
            height: 8px;
            border-radius: 10px;
            background: #e9ecef;
            overflow: hidden;
        }

        .progress-bar {
            background: linear-gradient(90deg, #667eea, #764ba2);
            animation: progressAnimation 2s ease-in-out infinite;
        }

        @keyframes progressAnimation {
            0% {
                width: 0%;
            }
            50% {
                width: 70%;
            }
            100% {
                width: 100%;
            }
        }

        .contact-info {
            border-top: 1px solid #e9ecef;
            padding-top: 25px;
        }

        .contact-info p {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .contact-info a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .contact-info a:hover {
            color: #764ba2;
        }

        .retry-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            margin-top: 20px;
        }

        .retry-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .gear-animation {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-bottom: 20px;
        }

        .gear {
            color: #667eea;
            font-size: 30px;
        }

        .gear:nth-child(1) {
            animation: spin 3s linear infinite;
        }

        .gear:nth-child(2) {
            animation: spin 3s linear infinite reverse;
            font-size: 24px;
            margin-top: 10px;
        }

        @media (max-width: 576px) {
            .maintenance-container {
                padding: 40px 25px;
            }

            .maintenance-title {
                font-size: 24px;
            }

            .maintenance-subtitle {
                font-size: 16px;
            }

            .maintenance-icon {
                width: 100px;
                height: 100px;
            }

            .maintenance-icon i {
                font-size: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">
            <i class="fas fa-tools"></i>
        </div>

        <div class="gear-animation">
            <i class="fas fa-cog gear"></i>
            <i class="fas fa-cog gear"></i>
        </div>

        <h1 class="maintenance-title">Hệ thống đang bảo trì</h1>
        
        <p class="maintenance-subtitle">
            Chúng tôi đang nâng cấp hệ thống để phục vụ bạn tốt hơn.
        </p>

        <div class="maintenance-message">
            <p>
                <i class="fas fa-info-circle me-2" style="color: #667eea;"></i>
                Hệ thống đang được bảo trì và nâng cấp. Vui lòng quay lại sau ít phút.
                Chúng tôi xin lỗi vì sự bất tiện này!
            </p>
        </div>

        <div class="progress-container">
            <div class="progress-label">
                <i class="fas fa-spinner"></i>
                <span>Đang tiến hành bảo trì...</span>
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar"></div>
            </div>
        </div>
    </div>

    <script>
        // Auto refresh after 60 seconds
        setTimeout(function() {
            location.reload();
        }, 60000);
    </script>
</body>
</html>
