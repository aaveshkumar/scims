<?php

class CalendarController
{
    public function index($request)
    {
        $events = db()->fetchAll("SELECT ce.*, CONCAT(u.first_name, ' ', u.last_name) as creator_name FROM calendar_events ce LEFT JOIN users u ON ce.created_by = u.id ORDER BY ce.event_date DESC");
        
        return view('calendar/index', [
            'title' => 'Calendar Events',
            'events' => $events
        ]);
    }

    public function create($request)
    {
        if ($request->method() === 'POST') {
            $authUser = auth();
            $sql = "INSERT INTO calendar_events (title, description, event_date, start_time, end_time, location, event_type, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
            
            db()->execute($sql, [
                $request->post('title'),
                $request->post('description'),
                $request->post('event_date'),
                $request->post('start_time'),
                $request->post('end_time'),
                $request->post('location'),
                $request->post('event_type') ?? 'event',
                isset($authUser['id']) ? $authUser['id'] : 1
            ]);
            
            flash('success', 'Event created successfully');
            return redirect('/calendar');
        }
        
        return view('calendar/create', ['title' => 'Create - Calendar Event']);
    }

    public function show($request, $id)
    {
        $event = db()->fetchOne("SELECT ce.*, CONCAT(u.first_name, ' ', u.last_name) as creator_name FROM calendar_events ce LEFT JOIN users u ON ce.created_by = u.id WHERE ce.id = ?", [$id]);
        
        if (!$event) {
            flash('error', 'Event not found');
            return redirect('/calendar');
        }
        
        return view('calendar/show', [
            'title' => 'View - Calendar Event',
            'event' => $event
        ]);
    }

    public function edit($request, $id)
    {
        $event = db()->fetchOne("SELECT * FROM calendar_events WHERE id = ?", [$id]);
        
        if (!$event) {
            flash('error', 'Event not found');
            return redirect('/calendar');
        }
        
        if ($request->method() === 'POST') {
            $sql = "UPDATE calendar_events SET title = ?, description = ?, event_date = ?, start_time = ?, end_time = ?, location = ?, event_type = ?, updated_at = NOW() WHERE id = ?";
            
            db()->execute($sql, [
                $request->post('title'),
                $request->post('description'),
                $request->post('event_date'),
                $request->post('start_time'),
                $request->post('end_time'),
                $request->post('location'),
                $request->post('event_type'),
                $id
            ]);
            
            flash('success', 'Event updated successfully');
            return redirect('/calendar');
        }
        
        return view('calendar/edit', [
            'title' => 'Edit - Calendar Event',
            'event' => $event
        ]);
    }

    public function destroy($request, $id)
    {
        db()->execute("DELETE FROM calendar_events WHERE id = ?", [$id]);
        flash('success', 'Event deleted successfully');
        return redirect('/calendar');
    }
}
