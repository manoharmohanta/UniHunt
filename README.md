# UniHunt.org

UniHunt.org is a **course and university discovery platform** designed to help students easily find universities, courses, and study-abroad opportunities. The platform focuses on simplicity, speed, and accurate information for students planning higher education, especially international studies.

---

## 🌍 About UniHunt

UniHunt acts as a **smart course finder** where students can:

* Search universities by country, course, or degree
* Explore detailed university profiles
* Compare courses and admission requirements
* Stay updated with university news and updates

The platform is built to support students, counselors, and education consultants.

---

## 🚀 Key Features

### 🎓 University & Course Search

* Search universities by **country, degree, or specialization**
* Filter courses based on level (UG, PG, Diploma)
* Easy-to-understand course details

### 🏫 University Profiles

* University overview and description
* Available courses
* Admission requirements
* Application deadlines

### 🔔 University Updates

* Latest university news
* Admission alerts
* Policy or intake updates

### ❤️ Course Bookmarking

* Users can bookmark favorite courses
* Quick access to saved universities

### 👤 User Accounts

* Student registration & login
* Profile management
* Personalized course suggestions (future-ready)

### 🔍 SEO & Performance Focused

* SEO-optimized pages
* Fast loading and mobile-friendly design

---

## 🛠️ Tech Stack

### Frontend

* HTML5, CSS3, JavaScript
* Bootstrap / Modern UI components

### Backend

* PHP (CodeIgniter 4)
* MVC Architecture

### Database

* MySQL

### APIs & Tools

* AJAX / HTMX for dynamic content
* JSON-based responses
* Email integration (PHPMailer)

---

## 📁 Project Structure (Backend)

```
app/
 ├── Controllers/
 ├── Models/
 ├── Views/
 ├── Config/
public/
 ├── assets/
 ├── uploads/
writable/
 ├── cache/
 ├── logs/
```

---

## 🔐 User Roles

* **Admin**

  * Manage universities and courses
  * Publish updates and blogs
  * Control user access

* **Student/User**

  * Search & bookmark courses
  * View updates
  * Manage profile

---

## 📱 Mobile Friendly

UniHunt is fully responsive and optimized for:

* Mobile phones
* Tablets
* Desktop browsers

Future plan includes a **Flutter mobile app** for Android & iOS.

---

## 🔮 Future Enhancements

* AI-based course recommendation system
* SOP Generator
* Scholarship finder
* University comparison tool
* Counselor dashboard
* Multi-language support

---

## ⚙️ Installation (Local Setup)

1. Clone the repository

```bash
git clone https://github.com/your-repo/unihunt.git
```

2. Configure `.env`

```env
baseURL = 'http://localhost/unihunt/public'
database.default.hostname = localhost
database.default.database = unihunt_db
database.default.username = root
database.default.password =
```

3. Run migrations (if available)

```bash
php spark migrate
```

4. Start local server

```bash
php spark serve
```

---

## 🔒 Security Measures

* Form validation & sanitization
* CSRF protection
* Secure authentication
* Encrypted URLs for sensitive data

---

## 🌐 Live Website

👉 **[https://unihunt.org](https://unihunt.org)**

---

## 🤝 Contributing

Contributions are welcome!

* Fork the project
* Create a feature branch
* Submit a pull request

---

## 📄 License

This project is proprietary and owned by **UniHunt**.
Unauthorized copying or redistribution is prohibited.

---

## 📞 Contact

For support or collaboration:

* Website: [https://unihunt.org](https://unihunt.org)
* Email: [support@unihunt.org](mailto:support@unihunt.org)

---

**UniHunt – Find Your Future, Smarter 🎓**