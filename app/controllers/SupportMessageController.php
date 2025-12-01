<?php

class SupportMessageController
{
    protected $supportMessageModel;

    public function __construct()
    {
        $this->supportMessageModel = new SupportMessage();
    }

    public function index($request)
    {
        try {
            // If user is admin, show admin dashboard instead
            if (hasRole('admin')) {
                $messages = $this->supportMessageModel->getForAdmin();
                
                return view('support.admin-index', [
                    'title' => 'Support Messages - Admin',
                    'messages' => $messages
                ]);
            }

            // For regular users, show their own messages
            $messages = $this->supportMessageModel->getForUser(auth()['id']);
            
            return view('support.index', [
                'title' => 'Support Messages',
                'messages' => $messages
            ]);
        } catch (Exception $e) {
            error_log('Support index error: ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            flash('error', 'Failed to load messages: ' . $e->getMessage());
            return redirect('/dashboard');
        }
    }

    public function create($request)
    {
        return view('support.create', [
            'title' => 'Send Message to Admin'
        ]);
    }

    public function store($request)
    {
        $subject = $request->post('subject');
        $message = $request->post('message');

        // Validate inputs
        if (empty($subject) || strlen($subject) < 5) {
            flash('error', 'Subject is required and must be at least 5 characters');
            return redirect('/support/create');
        }

        if (empty($message) || strlen($message) < 10) {
            flash('error', 'Message is required and must be at least 10 characters');
            return redirect('/support/create');
        }

        try {
            $this->supportMessageModel->create([
                'user_id' => auth()['id'],
                'subject' => $subject,
                'message' => $message,
                'status' => 'open'
            ]);

            flash('success', 'Message sent to admin successfully!');
            return redirect('/support');
        } catch (Exception $e) {
            flash('error', 'Failed to send message: ' . $e->getMessage());
            return redirect('/support/create');
        }
    }

    public function show($request, $id)
    {
        try {
            $message = $this->supportMessageModel->find($id);
            
            if (!$message) {
                flash('error', 'Message not found');
                return redirect('/support');
            }

            // Check authorization
            if ($message['user_id'] != auth()['id'] && !hasRole('admin')) {
                flash('error', 'Unauthorized access');
                return redirect('/support');
            }

            $user = $this->supportMessageModel->getUserInfo($message['user_id']);
            $admin = $message['admin_replied_by'] ? $this->supportMessageModel->getAdminInfo($message['admin_replied_by']) : null;

            return view('support.show', [
                'title' => 'View Message',
                'message' => $message,
                'user' => $user,
                'admin' => $admin
            ]);
        } catch (Exception $e) {
            flash('error', 'Failed to load message');
            return redirect('/support');
        }
    }

    public function reply($request, $id)
    {
        try {
            if (!hasRole('admin')) {
                flash('error', 'Unauthorized access');
                return redirect('/support');
            }

            $message = $this->supportMessageModel->find($id);
            
            if (!$message || !is_array($message)) {
                flash('error', 'Message not found');
                return redirect('/support');
            }

            $user = $this->supportMessageModel->getUserInfo($message['user_id']);
            
            if (!$user || !is_array($user)) {
                flash('error', 'User information not found');
                return redirect('/support');
            }

            return view('support.reply', [
                'title' => 'Reply to Message',
                'message' => $message,
                'user' => $user
            ]);
        } catch (Exception $e) {
            error_log('Reply view error: ' . $e->getMessage());
            flash('error', 'Failed to load message: ' . $e->getMessage());
            return redirect('/support');
        }
    }

    public function sendReply($request, $id)
    {
        if (!hasRole('admin')) {
            flash('error', 'Unauthorized access');
            return redirect('/support');
        }

        $reply = $request->post('admin_reply');

        // Validate reply
        if (empty($reply) || strlen($reply) < 5) {
            flash('error', 'Reply is required and must be at least 5 characters');
            return redirect("/support/$id/reply");
        }

        try {
            $message = $this->supportMessageModel->find($id);
            
            if (!$message) {
                flash('error', 'Message not found');
                return redirect('/support');
            }

            $this->supportMessageModel->addReply($id, $reply, auth()['id']);

            flash('success', 'Reply sent successfully!');
            return redirect('/support');
        } catch (Exception $e) {
            flash('error', 'Failed to send reply: ' . $e->getMessage());
            return redirect("/support/$id/reply");
        }
    }

    public function admin($request)
    {
        if (!hasRole('admin')) {
            flash('error', 'Unauthorized access');
            return redirect('/dashboard');
        }

        try {
            $messages = $this->supportMessageModel->getForAdmin();
            
            return view('support.admin-index', [
                'title' => 'Support Messages - Admin',
                'messages' => $messages
            ]);
        } catch (Exception $e) {
            flash('error', 'Failed to load messages');
            return redirect('/dashboard');
        }
    }

    public function closeTicket($request, $id)
    {
        if (!hasRole('admin')) {
            flash('error', 'Unauthorized access');
            return redirect('/support');
        }

        try {
            $message = $this->supportMessageModel->find($id);
            
            if (!$message) {
                flash('error', 'Message not found');
                return redirect('/support');
            }

            $this->supportMessageModel->markAsResolved($id);

            flash('success', 'Ticket closed successfully!');
            return redirect('/support');
        } catch (Exception $e) {
            flash('error', 'Failed to close ticket: ' . $e->getMessage());
            return redirect('/support');
        }
    }
}
