# 👨‍🏫 Teacher Quick Reference Card

## 🔐 Login
- URL: `/login`
- Email: `teacher@school.com`
- Password: `password`

## 📍 Main Routes

| Feature | URL | Description |
|---------|-----|-------------|
| Dashboard | `/teacher/dashboard` | Main dashboard with stats |
| All Classes | `/teacher/classes` | List of your classes |
| Class Details | `/teacher/classes/{id}` | View class roster |
| All Grades | `/teacher/classes/{id}/grades` | View all grades |
| Enter Grades | `/teacher/classes/{id}/grades/create` | Bulk grade entry |
| Edit Grade | `/teacher/classes/{id}/grades/{grade}/edit` | Edit single grade |
| Attendance History | `/teacher/classes/{id}/attendance` | View attendance |
| Mark Attendance | `/teacher/classes/{id}/attendance/create` | Mark attendance |
| Edit Attendance | `/teacher/classes/{id}/attendance/{date}/edit` | Edit attendance |
| Attendance Report | `/teacher/classes/{id}/attendance/report` | Full report |

## 🎯 Quick Actions

### From Dashboard:
- Click class name → View class details
- View today's schedule
- See recent activity

### From Class Details:
- **Enter Grades** → Bulk grade entry form
- **Mark Attendance** → Attendance marking form
- **View All Grades** → Complete grade history
- **View Attendance** → Attendance records

### From Grades Page:
- **Enter New Grades** → Add grades for assessment
- **Edit** → Modify individual grade
- **Delete** → Remove grade (with confirmation)

### From Attendance Page:
- **Mark Attendance** → Mark for today or any date
- **View Report** → Comprehensive statistics
- **Edit** → Modify attendance for date

## 📝 Grade Entry

### Assessment Types:
- Quiz
- Exam
- Assignment
- Project
- Lab
- Essay

### Grading Scale:
- **A:** 90-100%
- **B:** 80-89%
- **C:** 70-79%
- **D:** 60-69%
- **F:** Below 60%

### Steps:
1. Select assessment type and date
2. Enter assessment name and max score
3. Enter scores for all students
4. Add optional remarks
5. Submit

## ✓ Attendance Marking

### Status Options:
- **Present** ✓ - Student attended
- **Absent** ✗ - Student did not attend
- **Late** ⏰ - Student arrived late
- **Excused** 📝 - Excused absence

### Quick Actions:
- **Mark All Present** - Sets all to present
- **Mark All Absent** - Sets all to absent

### Steps:
1. Select date (defaults to today)
2. Mark status for each student
3. Add optional remarks
4. Submit

## 📊 Reports

### Attendance Report Shows:
- Total days tracked
- Present/Absent/Late/Excused counts
- Attendance percentage
- Status indicator:
  - **Excellent:** ≥90%
  - **Good:** 75-89%
  - **Fair:** 60-74%
  - **Poor:** <60%
- Class average
- Print-friendly format

### Grade Summary Shows:
- All grades by date
- Student averages
- Letter grades
- Assessment details

## 🎨 Color Codes

### Grades:
- 🟢 **Green:** A (Excellent)
- 🔵 **Blue:** B (Good)
- 🟡 **Yellow:** C (Average)
- 🟠 **Orange:** D (Below Average)
- 🔴 **Red:** F (Failing)

### Attendance:
- 🟢 **Green:** Present
- 🔴 **Red:** Absent
- 🟡 **Yellow:** Late
- 🔵 **Blue:** Excused

### Status:
- 🟢 **Green:** Excellent (≥90%)
- 🔵 **Blue:** Good (75-89%)
- 🟡 **Yellow:** Fair (60-74%)
- 🔴 **Red:** Poor (<60%)

## ⚡ Keyboard Shortcuts

### Forms:
- **Tab** - Move to next field
- **Enter** - Submit form (when focused on button)
- **Esc** - Cancel (use back button)

### Print:
- **Ctrl+P** (Windows) or **Cmd+P** (Mac) - Print report

## 💡 Tips

### Daily Routine:
1. Login to dashboard
2. Check today's schedule
3. Mark attendance for each class
4. Enter grades as assessments are completed
5. Review recent activity

### Best Practices:
- Mark attendance at start of class
- Enter grades promptly after grading
- Use descriptive assessment names
- Add remarks for students needing feedback
- Review attendance reports weekly
- Check student averages regularly

### Time Savers:
- Use "Mark All Present" for full attendance
- Enter grades for entire class at once
- Use print function for physical copies
- Check dashboard for quick overview

## 🔒 Security

- Only you can access your classes
- All forms are CSRF protected
- Changes are logged
- Automatic session timeout
- Secure password required

## 📱 Mobile Friendly

All pages work on:
- Desktop computers
- Tablets
- Mobile phones
- Print (reports)

## ❓ Common Questions

**Q: Can I edit grades after entering them?**
A: Yes! Click "Edit" next to any grade.

**Q: Can I change attendance after marking it?**
A: Yes! Click "Edit" next to the date.

**Q: How is the average calculated?**
A: Average of all grades in the class.

**Q: What if I mark attendance wrong?**
A: Edit the attendance for that date.

**Q: Can I delete a grade?**
A: Yes, with confirmation dialog.

**Q: How do I print reports?**
A: Click print button or use Ctrl+P.

**Q: Can I see student history?**
A: Yes, view class details for full history.

**Q: What if a student is excused?**
A: Mark as "Excused" status.

## 🆘 Need Help?

1. Check documentation files
2. Review this quick reference
3. Contact system administrator
4. Check Laravel logs for errors

## 📞 Support

For technical issues:
- Check `storage/logs/laravel.log`
- Clear cache: `php artisan cache:clear`
- Clear views: `php artisan view:clear`

---

**Everything you need at your fingertips!** 🎓
