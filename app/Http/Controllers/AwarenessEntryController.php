<?php

namespace App\Http\Controllers;

use App\Models\QualityScore;
use Illuminate\Http\Request;
use App\Models\AwarenessEntry;
use App\Services\QualityScoreService;
use Illuminate\Support\Facades\Auth;

class AwarenessEntryController extends Controller
{
    protected $qualityScoreService;

    public function __construct(QualityScoreService $qualityScoreService)
    {
        $this->qualityScoreService = $qualityScoreService;
    }

    public function index()
    {
        //for reminder
        $today = now()->format('Y-m-d');
        $hasEnteredToday = AwarenessEntry::where('user_id', Auth::id())
            ->whereDate('created_at', $today)
            ->exists();

        session(['awareness_reminder' => !$hasEnteredToday]);

        //awareness with score
        $entries = AwarenessEntry::with('qualityScore')
            ->where('user_id', Auth::id())
            ->get();

        //for stats
        $qualityScores = QualityScore::where('user_id', Auth::id())->get();
        $weeklyMood = $this->qualityScoreService->getWeeklyMood();
        $lastWeekDayMood = $this->qualityScoreService->getLastWeekSameDayData();

        return view('awarenessEntry', compact('lastWeekDayMood', 'weeklyMood', 'entries', 'qualityScores'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateEntry($request);

        $awarenessEntry = AwarenessEntry::create([
            'user_id' => Auth::id(),
            'creative_hours' => $validatedData['creative_hours'],
            'note' => $validatedData['note'],
        ]);

        //creating data in another table
        QualityScore::create([
            'user_id' => Auth::id(),
            'awareness_entry_id' => $awarenessEntry->id,
            'score' => $validatedData['score']
        ]);

        return redirect()->route('awarenessEntry.index')->with('success', 'Entry created successfully');
    }

    private function validateEntry(Request $request)
    {
        //validation
        return $request->validate([
            'creative_hours' => 'required|numeric|min:0',
            'score' => 'required|integer|between:-2,2',
            'note' => 'required|string',
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'creative_hours' => 'required|numeric|min:0',
            'score' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $entry = AwarenessEntry::findOrFail($id);

        $entry->creative_hours = $validatedData['creative_hours'];
        $entry->note = $validatedData['note'];
        $entry->qualityScore()->update(['score' => $validatedData['score']]);
        $entry->save();
        return redirect()->route('awarenessEntry.index')->with('success', 'Entry updated successfully.');
    }

    public function destroy(string $id)
    {
        $entry = $this->getUserEntry($id);
        $entry->delete();
        return redirect()->route('awarenessEntry.index')->with('success', 'Entry deleted successfully');
    }

    private function getUserEntry(string $id)
    {
        return AwarenessEntry::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

}
