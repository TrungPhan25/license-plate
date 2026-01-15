<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ViolationRequest;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ViolationController extends Controller
{
    /**
     * Display a listing of violations
     */
    public function index(Request $request): View
    {
        $query = Violation::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->byLicensePlate($search)
                  ->orWhere->byFullName($search);
            });
        }

        // Date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->byDateRange($request->get('start_date'), $request->get('end_date'));
        }

        // Filter by trash status
        if ($request->get('status') === 'trash') {
            $query->onlyTrashed();
        }

        $violations = $query->latest('violation_date')->paginate(15)->appends($request->query());

        return view('admin.violations.index', compact('violations'));
    }

    /**
     * Show the form for creating a new violation
     */
    public function create(): View
    {
        return view('admin.violations.create');
    }

    /**
     * Store a newly created violation
     */
    public function store(ViolationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('violations', 'public');
        }

        Violation::create($data);

        return redirect()->route('admin.violations.index')
            ->with('success', 'Tạo vi phạm thành công!');
    }

    /**
     * Display the specified violation
     */
    public function show(Violation $violation): View
    {
        return view('admin.violations.show', compact('violation'));
    }

    /**
     * Show the form for editing the specified violation
     */
    public function edit(Violation $violation): View
    {
        return view('admin.violations.edit', compact('violation'));
    }

    /**
     * Update the specified violation
     */
    public function update(ViolationRequest $request, Violation $violation): RedirectResponse
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($violation->image) {
                Storage::disk('public')->delete($violation->image);
            }
            $data['image'] = $request->file('image')->store('violations', 'public');
        }

        $violation->update($data);

        return redirect()->route('admin.violations.index')
            ->with('success', 'Cập nhật vi phạm thành công!');
    }

    /**
     * Soft delete the specified violation
     */
    public function destroy(Violation $violation): RedirectResponse
    {
        $violation->delete();

        return redirect()->route('admin.violations.index')
            ->with('success', 'Xóa vi phạm thành công!');
    }

    /**
     * Show the trashed violations
     */
    public function trash(Request $request): View
    {
        $query = Violation::onlyTrashed();

        // Search functionality for trashed items
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->byLicensePlate($search)
                  ->orWhere->byFullName($search);
            });
        }

        $violations = $query->latest('deleted_at')->paginate(15)->appends($request->query());

        return view('admin.violations.trash', compact('violations'));
    }

    /**
     * Restore the specified violation
     */
    public function restore($id): RedirectResponse
    {
        $violation = Violation::withTrashed()->findOrFail($id);
        $violation->restore();

        return redirect()->route('admin.violations.trash')
            ->with('success', 'Khôi phục vi phạm thành công!');
    }

    /**
     * Permanently delete the specified violation
     */
    public function forceDelete($id): RedirectResponse
    {
        $violation = Violation::withTrashed()->findOrFail($id);
        
        // Delete image if exists
        if ($violation->image) {
            Storage::disk('public')->delete($violation->image);
        }
        
        $violation->forceDelete();

        return redirect()->route('admin.violations.trash')
            ->with('success', 'Xóa vĩnh viễn vi phạm thành công!');
    }
}
