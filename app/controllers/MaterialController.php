<?php

class MaterialController
{
    private $materialModel;
    private $subjectModel;
    private $classModel;

    public function __construct()
    {
        $this->materialModel = new Material();
        $this->subjectModel = new Subject();
        $this->classModel = new ClassModel();
    }

    public function index($request)
    {
        $classId = $request->get('class_id');
        $subjectId = $request->get('subject_id');

        $query = "SELECT m.*, s.name as subject_name, c.name as class_name,
                         u.first_name, u.last_name
                  FROM materials m
                  LEFT JOIN subjects s ON m.subject_id = s.id
                  LEFT JOIN classes c ON m.class_id = c.id
                  INNER JOIN users u ON m.uploaded_by = u.id
                  WHERE m.status = 'active'";
        
        $params = [];

        if ($classId) {
            $query .= " AND m.class_id = ?";
            $params[] = $classId;
        }

        if ($subjectId) {
            $query .= " AND m.subject_id = ?";
            $params[] = $subjectId;
        }

        $query .= " ORDER BY m.created_at DESC";

        $materials = db()->fetchAll($query, $params);
        $classes = $this->classModel->where('status', 'active')->get();
        $subjects = $this->subjectModel->where('status', 'active')->get();

        return view('materials.index', [
            'materials' => $materials,
            'classes' => $classes,
            'subjects' => $subjects
        ]);
    }

    public function create($request)
    {
        $classes = $this->classModel->where('status', 'active')->get();
        $subjects = $this->subjectModel->where('status', 'active')->get();
        $subjectId = $request->get('subject_id');
        $classId = $request->get('class_id');

        return view('materials.create', [
            'classes' => $classes,
            'subjects' => $subjects,
            'subjectId' => $subjectId,
            'classId' => $classId
        ]);
    }

    public function store($request)
    {
        $rules = [
            'title' => 'required',
            'class_id' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        if (!$request->hasFile('file')) {
            flash('error', 'Please select a file to upload');
            return back();
        }

        try {
            $file = $request->file('file');
            $filePath = uploadFile($file, 'uploads/materials');

            if (!$filePath) {
                flash('error', 'File upload failed');
                return back();
            }

            $this->materialModel->create([
                'title' => $request->post('title'),
                'description' => $request->post('description'),
                'file_path' => $filePath,
                'file_type' => $file['type'],
                'file_size' => $file['size'],
                'subject_id' => $request->post('subject_id'),
                'class_id' => $request->post('class_id'),
                'uploaded_by' => auth()['id'],
                'type' => $request->post('type', 'notes'),
                'status' => 'active'
            ]);

            flash('success', 'Material uploaded successfully');
            return redirect('/materials');
        } catch (Exception $e) {
            flash('error', 'Failed to upload material: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $material = db()->fetchOne(
            "SELECT m.*, s.name as subject_name, c.name as class_name,
                    u.first_name, u.last_name
             FROM materials m
             LEFT JOIN subjects s ON m.subject_id = s.id
             LEFT JOIN classes c ON m.class_id = c.id
             INNER JOIN users u ON m.uploaded_by = u.id
             WHERE m.id = ?",
            [$id]
        );

        if (!$material) {
            flash('error', 'Material not found');
            return redirect('/materials');
        }

        return view('materials.show', ['material' => $material]);
    }

    public function download($request, $id)
    {
        $material = $this->materialModel->find($id);
        if (!$material) {
            flash('error', 'Material not found');
            return redirect('/materials');
        }

        $materialObj = new Material();
        foreach ($material as $key => $value) {
            $materialObj->$key = $value;
        }
        $materialObj->incrementDownloads();

        $filePath = PUBLIC_PATH . $material['file_path'];

        if (!file_exists($filePath)) {
            flash('error', 'File not found');
            return redirect('/materials');
        }

        return (new Response())->download($filePath);
    }

    public function destroy($request, $id)
    {
        try {
            $material = $this->materialModel->find($id);
            if ($material && file_exists(PUBLIC_PATH . $material['file_path'])) {
                unlink(PUBLIC_PATH . $material['file_path']);
            }

            $this->materialModel->delete($id);
            return responseJSON(['success' => true, 'message' => 'Material deleted successfully']);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
