# Resume Builder

A simple and interactive **Resume Builder** web application built with **Laravel** and **Tailwind CSS**. Users can create professional resumes in minutes and download them as PDFs using different templates.

---

## Features

- Create and customize resumes with personal, professional, and educational details.  
- Add multiple entries for employment, education, skills, and languages.  
- Data stored and managed using **MySQL** with **Eloquent ORM**.  
- Fully functional backend with **models**, **controllers**, and **migrations**.  
- Preview and select different resume templates.  
- Download resumes in PDF format using `Barryvdh/DomPDF`.  
- Responsive design with **Tailwind CSS** for mobile and desktop devices.  
- Progress bar to track form completion.

---

## Tech Stack

- **Backend:** PHP 8.x, Laravel 12.x, MySQL, Eloquent ORM  
- **Frontend:** Blade templates, Tailwind CSS  
- **PDF Generation:** [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)  
- **Database:** MySQL (with migrations and relationships)  

---

## Installation

1. **Clone the repository**
```bash
git clone https://github.com/NimraAsmat/resume.git
cd resume
```

2. **Install dependencies**
```bash
composer install
npm install
npm run dev
```

3. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database setup**
- Create a MySQL database (e.g., `resume`)
- Update `.env` file:
  ```
  DB_DATABASE=resume
  DB_USERNAME=root
  DB_PASSWORD=
  ```
- Run migrations:
  ```bash
  php artisan migrate
  ```

5. **Serve the application**
```bash
php artisan serve
```

Visit `http://127.0.0.1:8000` in your browser.

---


## Usage

1. Open the Resume Builder at `/resume`.  
2. Fill in personal details, professional summary, employment history, education, skills, and languages.  
3. Select a resume template.  
4. Click **Download** to generate a PDF resume.

---

## PDF Templates

- **Template 1:** Professional Blue  
- **Template 2:** Modern Black  
- **Template 3:** Creative Green  

Templates are located in `resources/views/templates/`.

---

## Dependencies

- Laravel Framework 12.x  
- barryvdh/laravel-dompdf  
- Tailwind CSS  
- Node.js & npm (for Tailwind build)

---

## Author

**Nimra Asmat**  

---

## License

This project is open-source and free to use.
