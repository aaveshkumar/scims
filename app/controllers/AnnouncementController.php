<?php

class AnnouncementController
{
    private $announcementModel;

    public function __construct()
    {
        $this->announcementModel = new Announcement();
    }

    public function index($request)
    {
        $announcements = $this->announcementModel->orderBy('published_date', 'DESC')->get();
        return view('announcements/index', [
            'title' => 'Announcements',
            'announcements' => $announcements
        ]);
    }

    public function create($request)
    {
        return view('announcements/create', ['title' => 'Create - Announcements']);
    }

    public function store($request)
    {
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'target_audience' => 'required',
            'priority' => 'required',
            'published_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            return redirect('/announcements/create')->with('errors', getValidationErrors());
        }

        try {
            $this->announcementModel->create([
                'title' => $request->post('title'),
                'content' => $request->post('content'),
                'target_audience' => $request->post('target_audience'),
                'priority' => $request->post('priority'),
                'published_by' => auth()['id'],
                'published_date' => $request->post('published_date'),
                'expiry_date' => $request->post('expiry_date'),
                'is_visible' => $request->post('is_visible') ? true : false
            ]);

            flash('success', 'Announcement created successfully');
            return redirect('/announcements');
        } catch (Exception $e) {
            flash('error', 'Failed to create announcement: ' . $e->getMessage());
            return redirect('/announcements/create');
        }
    }

    public function show($request, $id)
    {
        try {
            $announcement = $this->announcementModel->find($id);
            
            if (!$announcement) {
                return view('404', ['title' => 'Not Found']);
            }

            // Increment views
            $this->announcementModel->incrementViews($id);

            return view('announcements/show', [
                'title' => 'View - Announcements',
                'announcement' => $announcement
            ]);
        } catch (Exception $e) {
            flash('error', 'Failed to load announcement');
            return redirect('/announcements');
        }
    }

    public function edit($request, $id)
    {
        try {
            $announcement = $this->announcementModel->find($id);
            
            if (!$announcement) {
                return view('404', ['title' => 'Not Found']);
            }

            return view('announcements/edit', [
                'title' => 'Edit - Announcements',
                'announcement' => $announcement
            ]);
        } catch (Exception $e) {
            flash('error', 'Failed to load announcement');
            return redirect('/announcements');
        }
    }

    public function update($request, $id)
    {
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'target_audience' => 'required',
            'priority' => 'required',
            'published_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            return redirect("/announcements/$id/edit")->with('errors', getValidationErrors());
        }

        try {
            $announcement = $this->announcementModel->find($id);
            
            if (!$announcement) {
                flash('error', 'Announcement not found');
                return redirect('/announcements');
            }

            $this->announcementModel->update($id, [
                'title' => $request->post('title'),
                'content' => $request->post('content'),
                'target_audience' => $request->post('target_audience'),
                'priority' => $request->post('priority'),
                'published_date' => $request->post('published_date'),
                'expiry_date' => $request->post('expiry_date'),
                'is_visible' => $request->post('is_visible') ? true : false
            ]);

            flash('success', 'Announcement updated successfully');
            return redirect('/announcements');
        } catch (Exception $e) {
            flash('error', 'Failed to update announcement: ' . $e->getMessage());
            return redirect("/announcements/$id/edit");
        }
    }

    public function destroy($request, $id)
    {
        try {
            $announcement = $this->announcementModel->find($id);
            
            if (!$announcement) {
                flash('error', 'Announcement not found');
                return redirect('/announcements');
            }

            $this->announcementModel->delete($id);
            flash('success', 'Announcement deleted successfully');
            return redirect('/announcements');
        } catch (Exception $e) {
            flash('error', 'Failed to delete announcement: ' . $e->getMessage());
            return redirect('/announcements');
        }
    }
}
