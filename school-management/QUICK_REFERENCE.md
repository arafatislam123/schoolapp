# 🚀 Quick Reference - Student Management

## URLs

| Action | URL |
|--------|-----|
| Student List | http://localhost:8000/admin/students |
| Add Student | http://localhost:8000/admin/students/create |
| View Student | http://localhost:8000/admin/students/{id} |
| Edit Student | http://localhost:8000/admin/students/{id}/edit |

## Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@school.com | password |
| Teacher | teacher@school.com | password |
| Student | student@school.com | password |
| Parent | parent@school.com | password |

## Student ID Format

- **Format**: STU + Year + 4-digit number
- **Example**: STU20240001, STU20240002
- **Generate**: Click "Generate" button on form
- **Auto-increment**: System tracks last number

## Grade Levels

- Grade 1 through Grade 12
- Optional sections: A, B, C, etc.

## Student Status

| Status | Meaning | Color |
|--------|---------|-------|
| Active | Currently enrolled | Green |
| Inactive | Temporarily not attending | Red |
| Graduated | Completed studies | Blue |
| Transferred | Moved to another school | Gray |

## Required Fields

### Must Have:
- ✅ Full Name
- ✅ Email (unique)
- ✅ Password (min 8 chars)
- ✅ Date of Birth
- ✅ Student ID (unique)
- ✅ Grade Level
- ✅ Admission Date
- ✅ Status

### Optional:
- Phone
- Address
- Section
- Parent/Guardian
- Medical Info
- Emergency Contact

## Search & Filter

### Search by:
- Student name
- Email address
- Student ID

### Filter by:
- Grade level
- Status

## Features Checklist

- [x] Student Registration
- [x] Student Profile
- [x] Auto Student ID Generation
- [x] Grade & Section Assignment
- [x] Parent Linking
- [x] Admission Date
- [x] Medical Information
- [x] Emergency Contacts
- [x] Search & Filter
- [x] Status Management
- [x] Edit & Update
- [x] Delete Student
- [x] View Complete Profile

## Quick Actions

### Add Student:
1. Go to `/admin/students`
2. Click "Add New Student"
3. Click "Generate" for Student ID
4. Fill form
5. Submit

### Link Parent:
1. Ensure parent account exists
2. In student form, select parent from dropdown
3. Save

### Search Student:
1. Type in search box
2. Or use filter dropdowns
3. Click "Search"

### View Profile:
1. Click "View" next to student
2. See all information

## Common Tasks

| Task | Steps |
|------|-------|
| Register new student | Dashboard → Manage Students → Add New Student |
| Generate Student ID | Click "Generate" button on form |
| Link to parent | Select parent from dropdown in form |
| Update grade level | Edit student → Change grade level → Save |
| Mark as graduated | Edit student → Change status to "Graduated" |
| Search by name | Enter name in search box → Search |
| Filter by grade | Select grade from dropdown → Search |

## Tips

💡 **Generate Student ID**: Always click "Generate" to avoid duplicates
💡 **Parent First**: Register parents before creating students
💡 **Medical Info**: Add allergies and conditions for safety
💡 **Emergency Contact**: Always include at least one contact
💡 **Status**: Use "Active" for current students
💡 **Search**: Use student ID for fastest search

## Keyboard Shortcuts

- `Tab` - Navigate between fields
- `Enter` - Submit form (when focused on button)
- `Esc` - Cancel (use Cancel button instead)

## Support

📖 Full Guide: `STUDENT_MANAGEMENT_GUIDE.md`
📋 Features List: `STUDENT_FEATURES_SUMMARY.md`
🎯 Complete Features: `COMPLETE_FEATURES_LIST.md`
