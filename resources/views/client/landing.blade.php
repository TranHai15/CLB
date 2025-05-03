@extends('layouts.home')
@section('css')
<style>
    :root {
        --color-primary: #3a86ff;
        --color-secondary: #121212;
        --color-accent: #ff006e;
        --color-bg: #ffffff;
        --color-bg-alt: #f8f9fa;
        --color-text: #333333;
        --color-text-light: #666666;
        --color-border: #e0e0e0;
        --shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        --transition: all 0.3s ease;
        --radius: 8px;
        --containers-width: 1200px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: "Poppins", sans-serif;
        line-height: 1.6;
        color: var(--color-text);
        background-color: var(--color-bg);
    }

    a {
        text-decoration: none;
        color: var(--color-text);
        transition: var(--transition);
    }

    ul {
        list-style: none;
    }

    img {
        max-width: 100%;
        height: auto;
        display: block;
    }

    .containers {
        width: 90%;
        max-width: var(--containers-width);
        margin: 0 auto;
        padding: 0 15px;
    }

    section {
        padding: 80px 0;
    }

    .section-title {
        font-size: 2.5rem;
        text-align: center;
        margin-bottom: 50px;
        position: relative;
    }

    .section-title::after {
        content: "";
        display: block;
        width: 80px;
        height: 4px;
        background-color: var(--color-primary);
        margin: 10px auto 0;
        border-radius: 2px;
    }

    .btn {
        display: inline-block;
        padding: 12px 30px;
        border-radius: var(--radius);
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        text-align: center;
    }

    .btn.primary {
        background-color: var(--color-primary);
        color: white;
    }

    .btn.primary:hover {
        background-color: var(--color-secondary);
        transform: translateY(-3px);
    }

    .btn.secondary {
        background-color: transparent;
        border: 2px solid var(--color-primary);
        color: var(--color-primary);
    }

    .btn.secondary:hover {
        background-color: var(--color-primary);
        color: white;
        transform: translateY(-3px);
    }

    /* Header & Navigation */
    header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        background-color: rgba(255, 255, 255, 0.95);
        box-shadow: var(--shadow);
        backdrop-filter: blur(10px);
    }

    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
    }

    .logo h1 {
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--color-primary);
    }

    .nav-links {
        display: flex;
    }

    .nav-links li {
        margin-left: 30px;
    }

    .nav-links a {
        position: relative;
        font-weight: 500;
    }

    .nav-links a:hover {
        color: var(--color-primary);
    }

    .nav-links a::after {
        content: "";
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -5px;
        left: 0;
        background-color: var(--color-primary);
        transition: var(--transition);
    }

    .nav-links a:hover::after {
        width: 100%;
    }

    .hamburger {
        display: none;
        flex-direction: column;
        cursor: pointer;
    }

    .hamburger span {
        display: block;
        width: 25px;
        height: 3px;
        background-color: var(--color-text);
        margin-bottom: 5px;
        border-radius: 3px;
        transition: var(--transition);
    }

    /* Hero Section */
    .hero {
        height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        background: linear-gradient(135deg,
                rgba(58, 134, 255, 0.1) 0%,
                rgba(255, 0, 110, 0.1) 100%);
    }

    .hero-content {
        max-width: 700px;
        padding-top: 70px;
    }

    .hero-content h1 {
        font-size: 3.5rem;
        margin-bottom: 20px;
        line-height: 1.2;
        color: var(--color-secondary);
    }

    .hero-content p {
        font-size: 1.2rem;
        margin-bottom: 40px;
        color: var(--color-text-light);
    }

    .cta-buttons {
        display: flex;
        gap: 15px;
    }

    /* About Section */
    .about {
        background-color: var(--color-bg-alt);
    }

    .about-content {
        display: flex;
        gap: 40px;
        align-items: center;
    }

    .about-text {
        flex: 1;
    }

    .about-text p {
        margin-bottom: 30px;
        font-size: 1.1rem;
    }

    .about-image {
        flex: 1;
    }

    .image-placeholder {
        width: 100%;
        aspect-ratio: 4/3;
        background-color: var(--color-border);
        border-radius: var(--radius);
        position: relative;
        overflow: hidden;
    }

    .image-placeholder::before {
        content: "IT Club Image";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: var(--color-text-light);
    }

    .stats {
        display: flex;
        gap: 30px;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--color-primary);
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--color-text-light);
    }

    /* Activities Section */
    .activities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
    }

    .activity-card {
        background-color: var(--color-bg);
        border-radius: var(--radius);
        padding: 30px;
        box-shadow: var(--shadow);
        transition: var(--transition);
        text-align: center;
    }

    .activity-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .icon {
        font-size: 2.5rem;
        color: var(--color-primary);
        margin-bottom: 20px;
    }

    .activity-card h3 {
        margin-bottom: 15px;
        font-size: 1.3rem;
    }

    /* Projects Section */
    .projects {
        background-color: var(--color-bg-alt);
    }

    .projects-slider {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .project-card {
        background-color: var(--color-bg);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .project-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .project-image {
        height: 200px;
        background-color: var(--color-border);
        position: relative;
    }

    .project-image::before {
        content: "Project Image";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: var(--color-text-light);
    }

    .project-info {
        padding: 20px;
    }

    .project-info h3 {
        margin-bottom: 10px;
        font-size: 1.3rem;
    }

    .project-info p {
        margin-bottom: 15px;
        color: var(--color-text-light);
    }

    .tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .tags span {
        background-color: rgba(58, 134, 255, 0.1);
        color: var(--color-primary);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
    }

    /* Contact Section */
    .contact-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 50px;
    }

    .contact-form {
        background-color: var(--color-bg);
        padding: 30px;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--color-border);
        border-radius: var(--radius);
        font-family: inherit;
        font-size: 1rem;
        transition: var(--transition);
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(58, 134, 255, 0.2);
    }

    .contact-info {
        padding: 30px;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .info-item i {
        font-size: 1.5rem;
        color: var(--color-primary);
        margin-right: 15px;
    }

    .social-links {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .social-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--color-primary);
        color: white;
        transition: var(--transition);
    }

    .social-link:hover {
        background-color: var(--color-secondary);
        transform: translateY(-3px);
    }

    /* Footer */
    footer {
        background-color: var(--color-secondary);
        color: white;
        padding: 60px 0 20px;
    }

    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .footer-logo h2 {
        color: white;
        margin-bottom: 15px;
    }

    .footer-logo p {
        color: rgba(255, 255, 255, 0.7);
    }

    .footer-links h3,
    .footer-newsletter h3 {
        color: white;
        margin-bottom: 20px;
        font-size: 1.2rem;
    }

    .footer-links ul li {
        margin-bottom: 10px;
    }

    .footer-links ul li a {
        color: rgba(255, 255, 255, 0.7);
        transition: var(--transition);
    }

    .footer-links ul li a:hover {
        color: var(--color-primary);
        padding-left: 5px;
    }

    .footer-newsletter p {
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 15px;
    }

    .newsletter-form {
        display: flex;
        gap: 10px;
    }

    .newsletter-form input {
        flex: 1;
        padding: 10px 15px;
        border: none;
        border-radius: var(--radius);
        font-family: inherit;
    }

    .newsletter-form .btn {
        padding: 10px 15px;
    }

    .copyright {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .hero-content h1 {
            font-size: 3rem;
        }

        .section-title {
            font-size: 2.2rem;
        }

        .about-content {
            flex-direction: column;
        }
    }

    @media (max-width: 768px) {
        .nav-links {
            position: fixed;
            top: 70px;
            left: -100%;
            width: 100%;
            height: calc(100vh - 70px);
            background-color: var(--color-bg);
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            transition: var(--transition);
        }

        .nav-links.active {
            left: 0;
        }

        .nav-links li {
            margin: 10px 0;
        }

        .hamburger {
            display: flex;
        }

        .hero-content h1 {
            font-size: 2.5rem;
        }

        .cta-buttons {
            flex-direction: column;
        }

        .about-content {
            text-align: center;
        }

        .stats {
            justify-content: center;
        }

        .projects-slider {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        section {
            padding: 60px 0;
        }

        .hero-content h1 {
            font-size: 2rem;
        }

        .hero-content p {
            font-size: 1rem;
        }

        .section-title {
            font-size: 1.8rem;
            margin-bottom: 30px;
        }

        .contact-content {
            grid-template-columns: 1fr;
        }

        .newsletter-form {
            flex-direction: column;
        }
    }

    /* View More Containers */
    .view-more-containers {
        text-align: center;
        margin-top: 40px;
    }
</style>
@endsection

@section('content')
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Câu lạc bộ IT</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
</head>

<body>
    <header>
        <div class="containers">
            <nav>
                <div class="logo">
                    <h1>IT Club</h1>
                </div>
                <ul class="nav-links">
                    <li><a href="#home">Trang chủ</a></li>
                    <li><a href="#about">Giới thiệu</a></li>
                    <li><a href="#activities">Hoạt động</a></li>
                    <li><a href="#projects">Dự án</a></li>
                    <li><a href="#contact">Liên hệ</a></li>
                </ul>
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </nav>
        </div>
    </header>

    <section id="home" class="hero">
        <div class="containers">
            <div class="hero-content">
                <h1>Chào mừng đến với Câu lạc bộ IT</h1>
                <p>Nơi kết nối đam mê công nghệ và phát triển kỹ năng chuyên môn</p>
                <div class="cta-buttons">
                    <!-- <a href="#about" class="btn primary">Tìm hiểu thêm</a> -->
                    <a href="#contact" class="btn primary">Tham gia ngay</a>
                    <a href="#contact" class="btn secondary">Blog</a>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="about">
        <div class="containers">
            <h2 class="section-title">Giới thiệu</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>
                        Câu lạc bộ IT là nơi quy tụ những sinh viên đam mê công nghệ thông
                        tin. Chúng tôi tạo môi trường học tập và phát triển kỹ năng chuyên
                        môn thông qua các hoạt động thực tế, dự án nhóm và chia sẻ kiến
                        thức.
                    </p>
                    <div class="stats">
                        <div class="stat-item">
                            <span class="stat-number">150+</span>
                            <span class="stat-label">Thành viên</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">20+</span>
                            <span class="stat-label">Dự án</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">30+</span>
                            <span class="stat-label">Sự kiện</span>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <div class="image-placeholder"></div>
                </div>
            </div>
        </div>
    </section>

    <section id="activities" class="activities">
        <div class="containers">
            <h2 class="section-title">Hoạt động của CLB</h2>
            <div class="activities-grid">
                <div class="activity-card">
                    <div class="icon"><i class="fas fa-laptop-code"></i></div>
                    <h3>Workshop Kỹ thuật</h3>
                    <p>
                        Các buổi workshop thực hành về lập trình, AI, web development và
                        nhiều chủ đề công nghệ khác.
                    </p>
                </div>
                <div class="activity-card">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <h3>Mentoring</h3>
                    <p>
                        Chương trình hướng dẫn 1-1 giữa các thành viên cũ và mới để hỗ trợ
                        phát triển kỹ năng.
                    </p>
                </div>
                <div class="activity-card">
                    <div class="icon"><i class="fas fa-trophy"></i></div>
                    <h3>Hackathon</h3>
                    <p>
                        Tổ chức và tham gia các cuộc thi lập trình để thử thách bản thân
                        và cùng nhau sáng tạo.
                    </p>
                </div>
                <div class="activity-card">
                    <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h3>Tech Talks</h3>
                    <p>
                        Buổi chia sẻ kiến thức từ các chuyên gia trong ngành và thành viên
                        CLB về các xu hướng công nghệ mới.
                    </p>
                </div>
            </div>
            <div class="view-more-containers">
                <a href="activities.html" class="btn secondary">Xem tất cả hoạt động</a>
            </div>
        </div>
    </section>

    <section id="projects" class="projects">
        <div class="containers">
            <h2 class="section-title">Dự án nổi bật</h2>
            <div class="projects-slider">
                <div class="project-card">
                    <div class="project-image"></div>
                    <div class="project-info">
                        <h3>Web App Quản lý Học tập</h3>
                        <p>
                            Ứng dụng web giúp sinh viên quản lý thời gian học tập và lập kế
                            hoạch hiệu quả.
                        </p>
                        <div class="tags">
                            <span>React</span>
                            <span>Node.js</span>
                            <span>MongoDB</span>
                        </div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image"></div>
                    <div class="project-info">
                        <h3>AI Chatbot Hỗ trợ Sinh viên</h3>
                        <p>
                            Chatbot thông minh giúp sinh viên trả lời các câu hỏi thường gặp
                            về kỳ thi và thủ tục hành chính.
                        </p>
                        <div class="tags">
                            <span>Python</span>
                            <span>NLP</span>
                            <span>Flask</span>
                        </div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image"></div>
                    <div class="project-info">
                        <h3>Mobile App Kết nối Cộng đồng</h3>
                        <p>
                            Ứng dụng di động giúp sinh viên tìm kiếm người cùng sở thích và
                            tổ chức các hoạt động chung.
                        </p>
                        <div class="tags">
                            <span>Flutter</span>
                            <span>Firebase</span>
                            <span>Dart</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="view-more-containers">
                <a href="projects.html" class="btn secondary">Xem tất cả dự án</a>
            </div>
        </div>
    </section>

    <section id="contact" class="contact">
        <div class="containers">
            <h2 class="section-title">Tham gia cùng chúng tôi</h2>
            <div class="contact-content">
                <div class="contact-form">
                    <form id="join-form">
                        <div class="form-group">
                            <label for="name">Họ và tên</label>
                            <input type="text" id="name" name="name" required />
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required />
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" id="phone" name="phone" />
                        </div>
                        <div class="form-group">
                            <label for="interest">Lĩnh vực quan tâm</label>
                            <select id="interest" name="interest">
                                <option value="">-- Chọn lĩnh vực --</option>
                                <option value="web">Web Development</option>
                                <option value="mobile">Mobile Development</option>
                                <option value="ai">AI/Machine Learning</option>
                                <option value="data">Data Science</option>
                                <option value="cybersecurity">Cybersecurity</option>
                                <option value="other">Khác</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Lời nhắn</label>
                            <textarea id="message" name="message" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn primary">Gửi đăng ký</button>
                    </form>
                </div>
                <div class="contact-info">
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Phòng 305, Nhà A3, Trường Đại học ABC</p>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <p>itclub@example.edu.vn</p>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <p>(+84) 123 456 789</p>
                    </div>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="containers">
            <div class="footer-content">
                <div class="footer-logo">
                    <h2>IT Club</h2>
                    <p>Nơi đam mê công nghệ được nuôi dưỡng</p>
                </div>
                <div class="footer-links">
                    <h3>Liên kết nhanh</h3>
                    <ul>
                        <li><a href="#home">Trang chủ</a></li>
                        <li><a href="#about">Giới thiệu</a></li>
                        <li><a href="#activities">Hoạt động</a></li>
                        <li><a href="#projects">Dự án</a></li>
                        <li><a href="#contact">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="footer-newsletter">
                    <h3>Đăng ký nhận tin</h3>
                    <p>Cập nhật các hoạt động và sự kiện mới nhất của CLB</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Email của bạn" />
                        <button type="submit" class="btn primary">Đăng ký</button>
                    </form>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2023 Câu lạc bộ IT. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>

@endsection
@section('js')
<!-- JS chỉ dùng cho trang này -->
<script>
    // Wait for the DOM to be fully loaded
    document.addEventListener("DOMContentLoaded", function() {
        // Mobile Navigation Toggle
        const hamburger = document.querySelector(".hamburger");
        const navLinks = document.querySelector(".nav-links");

        if (hamburger) {
            hamburger.addEventListener("click", function() {
                navLinks.classList.toggle("active");
                this.classList.toggle("active");
            });
        }

        // Smooth scroll for navigation links
        const scrollLinks = document.querySelectorAll('a[href^="#"]');

        scrollLinks.forEach((link) => {
            link.addEventListener("click", function(e) {
                e.preventDefault();

                // Close mobile menu if open
                if (navLinks.classList.contains("active")) {
                    navLinks.classList.remove("active");
                    hamburger.classList.remove("active");
                }

                const targetId = this.getAttribute("href");
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: "smooth"
                    });
                }
            });
        });

        // Header scroll effect
        const header = document.querySelector("header");
        let lastScrollTop = 0;

        window.addEventListener("scroll", function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop) {
                // Scrolling down
                header.style.transform = "translateY(-100%)";
            } else {
                // Scrolling up
                header.style.transform = "translateY(0)";
            }

            // Update scroll position
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;

            // Add box shadow when scrolled
            if (scrollTop > 50) {
                header.classList.add("scrolled");
            } else {
                header.classList.remove("scrolled");
            }
        });

        // Form submission handling
        const joinForm = document.getElementById("join-form");
        const newsletterForm = document.querySelector(".newsletter-form");

        if (joinForm) {
            joinForm.addEventListener("submit", function(e) {
                e.preventDefault();

                // Simple form validation
                const nameInput = document.getElementById("name");
                const emailInput = document.getElementById("email");

                if (!nameInput.value.trim() || !emailInput.value.trim()) {
                    alert("Vui lòng điền đầy đủ thông tin bắt buộc");
                    return;
                }

                // Here you would normally send the form data to a server
                // For demo purposes, just show a success message
                alert("Cảm ơn bạn đã đăng ký! Chúng tôi sẽ liên hệ với bạn sớm.");
                joinForm.reset();
            });
        }

        if (newsletterForm) {
            newsletterForm.addEventListener("submit", function(e) {
                e.preventDefault();

                const emailInput = this.querySelector('input[type="email"]');

                if (!emailInput.value.trim()) {
                    alert("Vui lòng nhập địa chỉ email của bạn");
                    console.log("🚀 ~ styleSheet:", styleSheet);
                    return;
                }

                // Here you would normally send the form data to a server
                // For demo purposes, just show a success message
                alert("Cảm ơn bạn đã đăng ký nhận tin!");
                this.reset();
            });
        }

        // Add animation on scroll
        const animateElements = document.querySelectorAll(
            ".activity-card, .project-card, .section-title, .about-content"
        );

        function checkIfInView() {
            animateElements.forEach((element) => {
                const elementPosition = element.getBoundingClientRect();
                const windowHeight = window.innerHeight;

                if (elementPosition.top < windowHeight * 0.8) {
                    element.classList.add("animate");
                }
            });
        }

        // Add animation class to CSS
        const styleSheet = document.styleSheet;
        const animationRule = `
        .animate {
            animation: fadeInUp 0.6s ease forwards;
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
    `;

        if (styleSheet?.insertRule) {
            styleSheet?.insertRule(animationRule, styleSheet.cssRules.length);
        }

        // Initialize animations
        window.addEventListener("scroll", checkIfInView);
        checkIfInView();
    });
</script>
@endsection