<?php

class HrController
{
    public function events($request)
    {
        $events = db()->fetchAll("SELECT he.*, CONCAT(u.first_name, ' ', u.last_name) as creator_name FROM hr_events he LEFT JOIN users u ON he.created_by = u.id ORDER BY he.event_date DESC");
        
        return view('hr/events', [
            'title' => 'HR Events',
            'events' => $events
        ]);
    }

    public function createEvent($request)
    {
        if ($request->method() === 'POST') {
            $authUser = auth();
            $sql = "INSERT INTO hr_events (title, description, event_date, event_type, location, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
            
            db()->execute($sql, [
                $request->post('title'),
                $request->post('description'),
                $request->post('event_date'),
                $request->post('event_type') ?? 'event',
                $request->post('location'),
                isset($authUser['id']) ? $authUser['id'] : 1
            ]);
            
            flash('success', 'HR Event created successfully');
            return redirect('/hr/events');
        }
        
        return view('hr/create-event', ['title' => 'Create - HR Event']);
    }

    public function showEvent($request, $id)
    {
        $event = db()->fetchOne("SELECT he.*, CONCAT(u.first_name, ' ', u.last_name) as creator_name FROM hr_events he LEFT JOIN users u ON he.created_by = u.id WHERE he.id = ?", [$id]);
        
        if (!$event) {
            flash('error', 'HR Event not found');
            return redirect('/hr/events');
        }
        
        return view('hr/show-event', [
            'title' => 'View - HR Event',
            'event' => $event
        ]);
    }

    public function editEvent($request, $id)
    {
        $event = db()->fetchOne("SELECT * FROM hr_events WHERE id = ?", [$id]);
        
        if (!$event) {
            flash('error', 'HR Event not found');
            return redirect('/hr/events');
        }
        
        if ($request->method() === 'POST') {
            $sql = "UPDATE hr_events SET title = ?, description = ?, event_date = ?, event_type = ?, location = ?, updated_at = NOW() WHERE id = ?";
            
            db()->execute($sql, [
                $request->post('title'),
                $request->post('description'),
                $request->post('event_date'),
                $request->post('event_type'),
                $request->post('location'),
                $id
            ]);
            
            flash('success', 'HR Event updated successfully');
            return redirect('/hr/events');
        }
        
        return view('hr/edit-event', [
            'title' => 'Edit - HR Event',
            'event' => $event
        ]);
    }

    public function deleteEvent($request, $id)
    {
        db()->execute("DELETE FROM hr_events WHERE id = ?", [$id]);
        flash('success', 'HR Event deleted successfully');
        return redirect('/hr/events');
    }
}
