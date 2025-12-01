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
            $messages = $this->supportMessageModel->getForUser(auth()['id']);
            
            return view('support.index', [
                'title' => 'Support Messages',
                'messages' => $messages
            ]);
        } catch (Exception $e) {
            flash('error', 'Failed to load messages');
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
        $rules = [
            'subject' => 'required|min:5',
            'message' => 'required|min:10'
        ];

        if (!validate($request->post(), $rules)) {
            return redirect('/support/create')->with('errors', getValidationErrors());
        }

        try {
            $this->supportMessageModel->create([
                'user_id' => auth()['id'],
                'subject' => $request->post('subject'),
                'message' => $request->post('message'),
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
            $message = $this->supportMessageModel->find($id);
            
            if (!$message || !hasRole('admin')) {
                flash('error', 'Unauthorized access');
                return redirect('/support');
            }

            $user = $this->supportMessageModel->getUserInfo($message['user_id']);

            return view('support.reply', [
                'title' => 'Reply to Message',
                'message' => $message,
                'user' => $user
            ]);
        } catch (Exception $e) {
            flash('error', 'Failed to load message');
            return redirect('/support');
        }
    }

    public function sendReply($request, $id)
    {
        if (!hasRole('admin')) {
            flash('error', 'Unauthorized access');
            return redirect('/support');
        }

        $rules = ['admin_reply' => 'required|min:5'];

        if (!validate($request->post(), $rules)) {
            return redirect("/support/$id/reply")->with('errors', getValidationErrors());
        }

        try {
            $message = $this->supportMessageModel->find($id);
            
            if (!$message) {
                flash('error', 'Message not found');
                return redirect('/support');
            }

            $this->supportMessageModel->addReply($id, $request->post('admin_reply'), auth()['id']);

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
