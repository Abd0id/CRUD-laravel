# 🎮 Laravel Gamified Live Coding

Learn Laravel **step by step** like a game! 🚀

## ⚡ Setup (Get Ready to Play)

After cloning the repo, set up the project:

1. **Install PHP dependencies:**

   ```bash
   composer install
   ```

2. **Copy the `.env` file:**

   ```bash
   cp .env.example .env
   ```

3. **Generate the app key:**

   ```bash
   php artisan key:generate
   ```

4. **Update `.env` with your database info** and make sure your database exists.

5. **Run database migrations:**

   ```bash
   php artisan migrate
   ```

6. **Start the development server:**

   ```bash
   php artisan serve
   ```

Now you’re ready to play!

---
## 📋 How It Works

Four levels to master Laravel:

1. **Level 1 – Dirty Route** ❌: Works, but bad practice
2. **Level 2 – Controller** ✅: Cleaner, organized code
3. **Level 3 – Middleware** 🛡️: Security & control
4. **Level 4 – Full System** 🏆: All concepts combined

### Features

* Click 🔒 locks to unlock levels
* Your progress is saved automatically
* Progress bar shows how far you are
* Reset anytime with **Ctrl+Shift+R** or the floating button

---

## 🗂️ Files You’ll See

```
├── index.blade.php             # Main menu
├── vip-space-level-1.blade.php # Level 1: Route with Closure
├── vip-space-level-2.blade.php # Level 2: Controller
├── vip-space-level-3.blade.php # Level 3: Middleware
└── vip-space.blade.php         # Level 4: Full system
```

---
---

## 🎨 Extra Fun

* Add levels by creating new view & updating index
* Change animations by editing `@keyframes` in CSS

---

## 📱 Works On Any Device

* Desktop / Laptop / Tablet / Mobile

---

## 🎓 What You’ll Learn

* Routes (Closure vs Controller)
* Controllers (MVC structure)
* Middleware (Security)
* Blade Views (Templates)
* Redirects & error handling
* Query parameters
* Best practices

---

## 📝 Quick Tips

* Test each level first
* Watch how code changes live
* Ask questions if confused
* Click locks as you finish levels
* Reset anytime if stuck

---

## ⚡ Controls

* 🔒 Click locks to unlock/lock levels
* Progress auto-saved
* Reset with **Ctrl+Shift+R** or button
* Dev console: `resetProgress()`

---

## 🐞 Problems?

* Page not loading → check `resources/views/` & run `php artisan view:clear`
* Middleware broken → check Kernel.php / restart server
* Styles missing → make sure Google Fonts loads

---

**Go level up your Laravel skills! 🎮**

---
## 🎮 Interactive Controls

### Unlock/Lock Levels

* Click 🔒 to toggle
* ✅ = unlocked, 🔒 = locked
* Progress auto-saved

### Reset Progress

* **Floating button**: "🔄 Reset"
* **Shortcut**: `Ctrl + Shift + R`
* **Console**: `resetProgress()`

```javascript
// Reset all progress
resetProgress()
```

### Dev Console

* View unlocked levels, commands, and debug messages

---

## 🐛 Troubleshooting

* **Page doesn’t load** → Ensure views in `resources/views/`, run `php artisan view:clear`
* **Middleware not working** → Check Kernel.php or bootstrap/app.php, restart server
* **Styles not applying** → Ensure inline CSS loads, check Google Fonts connectivity

---

## 📝 License

Free to use for Laravel presentations & trainings

## 🤝 Contribution

Contributions and feedback welcome!

---

**Happy live coding! 🚀**
