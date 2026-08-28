<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Doctor & Department Management</title>
    <style>
        body {
            background-color: #cfedfa;
            font-family: Arial, sans-serif;
        }

        input, select, textarea, button {
            padding: 8px;
            margin: 4px;
        }

        textarea {
            vertical-align: top;
        }

        button {
            background-color: #1714af;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0e0b7a;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            text-align: left;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #1714af;
            padding: 8px;
            background-color: #d0d0d0;
        }

        th {
            background-color: #1714af;
            color: white;
        }

        .tabs input {
            display: none;
        }

        .tabs label {
            display: inline-block;
            padding: 10px 18px;
            margin: 4px 0;
            background-color: #d0d0d0;
            border: 1px solid #1714af;
            cursor: pointer;
        }

        .tab-content {
            display: none;
            margin-top: 10px;
        }

        #departments:checked ~ #department-content,
        #doctors:checked ~ #doctor-content {
            display: block;
        }

        #departments:checked + label,
        #doctors:checked + label {
            background-color: #1714af;
            color: white;
        }

        .form-table {
            width: auto;
            margin-top: 10px;
        }

        .form-table td:first-child {
            background-color: #1714af;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Doctor & Department Management</h1>

    <div class="tabs">
        <input type="radio" id="departments" name="tab" checked>
        <label for="departments">Departments</label>
        <input type="radio" id="doctors" name="tab">
        <label for="doctors">Doctors</label>

        <div id="department-content" class="tab-content">
            <h2>Departments</h2>
            <button type="button">+ Add Department</button>
            <input type="text" placeholder="Search Department">

            <table>
                <tr>
                    <th>ID</th>
                    <th>Department Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Doctors</th>
                    <th>Action</th>
                </tr>
            </table>

            <h2>Add / Edit Department</h2>
            <table class="form-table">
                <tr><td>Department Name</td><td><input type="text" name="department_name"></td></tr>
                <tr><td>Description</td><td><textarea name="description"></textarea></td></tr>
                <tr><td>Status</td><td><select name="status"><option>Active</option><option>Inactive</option></select></td></tr>
                <tr><td colspan="2"><button type="button">Save</button></td></tr>
            </table>
        </div>

        <div id="doctor-content" class="tab-content">
            <h2>Doctors</h2>
            <button type="button">+ Scan for new Doctors</button>
            <input type="text" placeholder="Search Doctor">
            <select>
                <option>Department Filter</option>
            </select>

            <table>
                <tr>
                    <th>Doctor</th>
                    <th>Department</th>
                    <th>Specialization</th>
                    <th>Qualification</th>
                    <th>Fee</th>
                    <th>Action</th>
                </tr>
            </table>

            <h2>Edit Doctor</h2>
            <table class="form-table">
                <tr><td>Doctor Name</td><td><input type="text" name="doctor_name"></td></tr>
                <tr><td>Assign Department</td><td><select name="department"><option>Select Department</option></select></td></tr>
                <tr><td>Specialization</td><td><input type="text" name="specialization"></td></tr>
                <tr><td>Qualification</td><td><input type="text" name="qualification"></td></tr>
                <tr><td>Experience</td><td><input type="number" name="experience"> Years</td></tr>
                <tr><td>Consultation Fee</td><td><input type="number" name="consultation_fee"></td></tr>
                <tr><td>Bio</td><td><textarea name="bio"></textarea></td></tr>
                <tr><td colspan="2"><button type="button">Save Changes</button></td></tr>
            </table>
        </div>
    </div>
</body>
</html>
