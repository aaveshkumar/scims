# Broken Links/Buttons That Need Fixing
**Generated:** 2025-11-17

## 🔴 HIGH PRIORITY - Linked in Sidebar (8 routes)

These are visible in the sidebar navigation but lead to 404 errors:

| # | Route | Sidebar Location | Status |
|---|-------|------------------|---------|
| 1 | `/roles` | Users → Roles & Permissions | ❌ No Controller |
| 2 | `/departments` | Users → Departments | ❌ No Controller |
| 3 | `/syllabus` | Academic → Syllabus | ❌ No Controller |
| 4 | `/lesson-plans` | Academic → Lesson Plans | ❌ No Controller |
| 5 | `/question-bank` | Academic → Question Bank | ❌ No Controller |
| 6 | `/academic-calendar` | Academic → Calendar | ❌ No Controller |
| 7 | `/leaves` | Operations → Leave Management | ❌ No Controller |
| 8 | `/report-cards` | Exams → Report Cards | ❌ No Controller |

---

## 🟠 MEDIUM PRIORITY - Linked in Sidebar (10 routes)

Finance Extensions in sidebar:

| # | Route | Sidebar Location | Status |
|---|-------|------------------|---------|
| 9 | `/fee-structure` | Finance → Fee Structure | ❌ No Controller |
| 10 | `/expenses` | Finance → Expenses | ❌ No Controller |
| 11 | `/payroll` | Finance → Payroll | ❌ No Controller |
| 12 | `/collections` | Finance → Collections | ❌ No Controller |

LMS Extensions in sidebar:

| # | Route | Sidebar Location | Status |
|---|-------|------------------|---------|
| 13 | `/assignments` | LMS → Assignments | ❌ No Controller |
| 14 | `/quizzes` | LMS → Quizzes | ❌ No Controller |
| 15 | `/online-classes` | LMS → Online Classes | ❌ No Controller |

Communication in sidebar:

| # | Route | Sidebar Location | Status |
|---|-------|------------------|---------|
| 16 | `/messages` | Communication → Messages | ❌ No Controller |
| 17 | `/sms` | Communication → SMS | ❌ No Controller |
| 18 | `/email` | Communication → Email | ❌ No Controller |

---

## 🟡 LOW PRIORITY - Advanced Features (29 routes)

These are in routes/web.php but not actively linked in current sidebar:

### Reports Module (4)
- `/reports/attendance`
- `/reports/finance`
- `/reports/academic`
- `/reports/custom`

### Settings Module (6)
- `/settings`
- `/settings/backup`
- `/settings/audit-logs`
- `/branches`
- `/integrations`
- `/logs`

### Transport Module (3)
- `/transport/vehicles`
- `/transport/routes`
- `/transport/assignments`

### Hostel Module (4)
- `/hostel/rooms`
- `/hostel/residents`
- `/hostel/visitors`
- `/hostel/complaints`

### Inventory Module (4)
- `/inventory/assets`
- `/inventory/stock`
- `/inventory/purchase-orders`
- `/inventory/suppliers`

### Other (8)
- `/admissions/waitlist`
- `/whatsapp`
- `/announcements`
- `/budget`
- `/fees`
- `/payments`

---

## 📋 Fixing Strategy

### Phase 1: HIGH PRIORITY (Do Now)
Fix 8 routes linked in sidebar that users can see and click

### Phase 2: MEDIUM PRIORITY (Do Next)
Fix 10 routes for finance, LMS, and communication modules

### Phase 3: LOW PRIORITY (Do Later)
Fix remaining 29 advanced feature routes

---

**Total Broken Routes**: 47
**Routes to Fix Immediately**: 8 (High Priority)
