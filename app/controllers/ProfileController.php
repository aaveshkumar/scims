<?php

class ProfileController
{
    public function index($request)
    {
        $user = auth();
        return view('profile/index', ['user' => $user, 'title' => 'My Profile']);
    }

    public function edit($request)
    {
        $user = auth();
        return view('profile/edit', ['user' => $user, 'title' => 'Edit Profile']);
    }

    public function update($request)
    {
        $userId = auth()['id'];
        $userModel = new User();
        
        $data = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
        ];

        if ($request->input('email') && $request->input('email') !== auth()['email']) {
            $existing = $userModel->where('email', $request->input('email'))->first();
            if ($existing) {
                flash('error', 'Email already exists');
                return redirect("/profile/edit");
            }
            $data['email'] = $request->input('email');
        }

        $userModel->update($userId, $data);
        flash('success', 'Profile updated successfully');
        return redirect('/profile');
    }

    public function documents($request)
    {
        $user = auth();
        return view('profile/documents', ['user' => $user, 'title' => 'My Documents']);
    }

    public function uploadDocument($request)
    {
        $file = $request->file('document');
        
        if (!$file) {
            flash('error', 'Please select a file');
            return redirect('/profile/documents');
        }

        $uploadDir = __DIR__ . '/../../public/uploads/documents/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = time() . '_' . $file['name'];
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            flash('success', 'Document uploaded successfully');
        } else {
            flash('error', 'Failed to upload document');
        }

        return redirect('/profile/documents');
    }

    public function changePassword($request)
    {
        return view('profile/change-password', ['title' => 'Change Password']);
    }

    public function updatePassword($request)
    {
        $userId = auth()['id'];
        $userModel = new User();
        $user = $userModel->find($userId);

        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');
        $confirmPassword = $request->input('confirm_password');

        if (!password_verify($currentPassword, $user['password'])) {
            flash('error', 'Current password is incorrect');
            return redirect('/profile/change-password');
        }

        if ($newPassword !== $confirmPassword) {
            flash('error', 'New passwords do not match');
            return redirect('/profile/change-password');
        }

        if (strlen($newPassword) < 8) {
            flash('error', 'Password must be at least 8 characters');
            return redirect('/profile/change-password');
        }

        $userModel->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        flash('success', 'Password changed successfully');
        return redirect('/profile');
    }
}
