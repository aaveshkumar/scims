<?php

class LessonPlanController
{
    public function index($request)
    {
        return view('lesson_plans/index', ['title' => 'Lesson Plans']);
    }

    public function create($request)
    {
        return view('lesson_plans/create', ['title' => 'Create - Lesson Plans']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/lesson_plans');
    }

    public function show($request, $id)
    {
        return view('lesson_plans/show', ['title' => 'View - Lesson Plans', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('lesson_plans/edit', ['title' => 'Edit - Lesson Plans', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/lesson_plans');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/lesson_plans');
    }
}