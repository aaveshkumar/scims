<?php

class MessageController
{
    private $messageModel;

    public function __construct()
    {
        $this->messageModel = new Message();
    }

    public function index($request)
    {
        $userId = auth()['id'];
        $messages = $this->messageModel->getReceivedMessages($userId);
        
        return view('messages.index', [
            'title' => 'Messages',
            'messages' => $messages
        ]);
    }

    public function create($request)
    {
        // Get list of users to send message to
        $users = $this->messageModel->getAllUsers(auth()['id']);
        
        return view('messages.create', [
            'title' => 'Create - Messages',
            'users' => $users
        ]);
    }

    public function store($request)
    {
        $rules = [
            'receiver_id' => 'required|numeric',
            'subject' => 'required',
            'message_body' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            return redirect('/messages/create')->with('errors', getValidationErrors());
        }

        try {
            $this->messageModel->create([
                'sender_id' => auth()['id'],
                'receiver_id' => $request->post('receiver_id'),
                'subject' => $request->post('subject'),
                'message_body' => $request->post('message_body')
            ]);

            flash('success', 'Message sent successfully');
            return redirect('/messages');
        } catch (Exception $e) {
            flash('error', 'Failed to send message: ' . $e->getMessage());
            return redirect('/messages/create');
        }
    }

    public function show($request, $id)
    {
        try {
            $message = $this->messageModel->find($id);
            
            if (!$message) {
                flash('error', 'Message not found');
                return redirect('/messages');
            }

            // Check if current user is receiver
            if ($message['receiver_id'] != auth()['id'] && $message['sender_id'] != auth()['id']) {
                flash('error', 'Unauthorized access');
                return redirect('/messages');
            }

            // Mark as read if user is receiver
            if ($message['receiver_id'] == auth()['id'] && !$message['is_read']) {
                $this->messageModel->markAsRead($id);
            }

            // Get sender/receiver details
            $sender = $this->messageModel->getUserInfo($message['sender_id']);
            $receiver = $this->messageModel->getUserInfo($message['receiver_id']);

            return view('messages.show', [
                'title' => 'View - Messages',
                'message' => $message,
                'sender' => $sender,
                'receiver' => $receiver
            ]);
        } catch (Exception $e) {
            flash('error', 'Failed to load message');
            return redirect('/messages');
        }
    }

    public function edit($request, $id)
    {
        try {
            $message = $this->messageModel->find($id);
            
            if (!$message) {
                flash('error', 'Message not found');
                return redirect('/messages');
            }

            // Check if current user is sender (editing) or receiver (replying)
            if ($message['sender_id'] != auth()['id'] && $message['receiver_id'] != auth()['id']) {
                flash('error', 'Cannot access this message');
                return redirect('/messages');
            }

            $users = $this->messageModel->getAllUsers(auth()['id']);
            
            // If replying to received message, pre-fill sender info
            if ($message['receiver_id'] == auth()['id']) {
                $receiver = $this->messageModel->getUserInfo($message['sender_id']);
            } else {
                $receiver = $this->messageModel->getUserInfo($message['receiver_id']);
            }

            return view('messages.edit', [
                'title' => 'Edit - Messages',
                'message' => $message,
                'receiver' => $receiver,
                'users' => $users,
                'isReply' => $message['receiver_id'] == auth()['id']
            ]);
        } catch (Exception $e) {
            flash('error', 'Failed to load message');
            return redirect('/messages');
        }
    }

    public function update($request, $id)
    {
        $rules = [
            'receiver_id' => 'required|numeric',
            'subject' => 'required',
            'message_body' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            return redirect("/messages/$id/edit")->with('errors', getValidationErrors());
        }

        try {
            $message = $this->messageModel->find($id);
            
            if (!$message) {
                flash('error', 'Message not found');
                return redirect('/messages');
            }

            // Check if current user is sender (editing) or receiver (replying)
            if ($message['sender_id'] != auth()['id'] && $message['receiver_id'] != auth()['id']) {
                flash('error', 'Cannot access this message');
                return redirect('/messages');
            }

            // If sender is editing their own message
            if ($message['sender_id'] == auth()['id']) {
                $this->messageModel->update($id, [
                    'receiver_id' => $request->post('receiver_id'),
                    'subject' => $request->post('subject'),
                    'message_body' => $request->post('message_body')
                ]);
                flash('success', 'Message updated successfully');
            } else {
                // If receiver is replying, create a new message instead
                $this->messageModel->create([
                    'sender_id' => auth()['id'],
                    'receiver_id' => $request->post('receiver_id'),
                    'subject' => 'Re: ' . $message['subject'],
                    'message_body' => $request->post('message_body'),
                    'parent_message_id' => $id
                ]);
                flash('success', 'Reply sent successfully');
            }

            return redirect('/messages');
        } catch (Exception $e) {
            flash('error', 'Failed to process message: ' . $e->getMessage());
            return redirect("/messages/$id/edit");
        }
    }

    public function destroy($request, $id)
    {
        try {
            $message = $this->messageModel->find($id);
            
            if (!$message || $message['sender_id'] != auth()['id']) {
                flash('error', 'Cannot delete this message');
                return redirect('/messages');
            }

            $this->messageModel->delete($id);
            flash('success', 'Message deleted successfully');
            return redirect('/messages');
        } catch (Exception $e) {
            flash('error', 'Failed to delete message: ' . $e->getMessage());
            return redirect('/messages');
        }
    }
}
