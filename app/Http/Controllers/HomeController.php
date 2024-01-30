<?php

namespace App\Http\Controllers;

use App\Models\BeritaModel;
use App\Models\IndexModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita = BeritaModel::all();
        return view('home', compact('berita'));
    }

    public function pembobotanIndex(Request $request)
    {
        $jumlahDokumen = BeritaModel::count();

        $tfidf = $this->tfIdf($request->search);

        return view('pembobotan', compact('berita'));
    }

    private function preprocessing($teks)
    {
        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();

        $stopWordRemoverFactory = new \Sastrawi\StopWordRemover\StopWordRemoverFactory();
        $stopword = $stopWordRemoverFactory->createStopWordRemover();

        $teks = strtolower($teks);
        $teks = $stemmer->stem($teks);

        $teks = $stopword->remove($teks);

        return $teks;
    }

    private function tfIdf($keyword)
    {
        $berita = BeritaModel::all();

        $keywordNormalize = $this->preprocessing($keyword);
        foreach ($berita as $beritaValue) {
            $beritaNormalize = $this->preprocessing($beritaValue->berita);
            $stem = explode(" ", trim($beritaNormalize));
            foreach ($stem as $key => $term) {
                //hanya jika Term tidak null atau nil, tidak kosong
                if ($term != "") {

                    //berapa baris hasil yang dikembalikan query tersebut?
                    $resCount = IndexModel::where('term', $term)->where('berita_id', $beritaValue->id)->first();

                    //jika sudah ada DocId dan Term tersebut    , naikkan Count (+1)
                    if (count($resCount) > 0) {
                        $count = $resCount->jumlah;
                        $count++;

                        IndexModel::where('term', $term)->where('berita_id', $beritaValue->id)->update([
                            'jumlah' => $count,
                        ]);
                    }
                    //jika belum ada, langsung simpan ke tbindex
                    else {
                        IndexModel::created([
                            'term' => $term,
                            'berita_id' => $beritaValue->id,
                            'jumlah' => 1,
                        ]);
                    }
                } //end if
            } //end foreach
        }
    }

    private function indexTfIdf()
    {
        $berita = BeritaModel::all();

        foreach ($berita as $beritaValue) {
            $beritaNormalize = $this->preprocessing($beritaValue->berita);
            $stem = explode(" ", trim($beritaNormalize));

            foreach ($stem as $key => $term) {
                //hanya jika Term tidak null atau nil, tidak kosong
                if ($term != "") {

                    //berapa baris hasil yang dikembalikan query tersebut?
                    $resCount = IndexModel::where('term', $term)->where('berita_id', $beritaValue->id)->first();

                    //jika sudah ada DocId dan Term tersebut    , naikkan Count (+1)
                    if (count($resCount) > 0) {
                        $count = $resCount->jumlah;
                        $count++;

                        IndexModel::where('term', $term)->where('berita_id', $beritaValue->id)->update([
                            'jumlah' => $count,
                        ]);
                    }
                    //jika belum ada, langsung simpan ke tbindex
                    else {
                        IndexModel::created([
                            'term' => $term,
                            'berita_id' => $beritaValue->id,
                            'jumlah' => 1,
                        ]);
                    }
                } //end if
            } //end foreach
        }
    }

    private function hitungBobot()
    {
        $n = IndexModel::select(DB::raw('DISTINCT berita_id'))->count();

        $index = IndexModel::all();

        foreach ($index as $indexValue) {
            $term = $indexValue->term;
            $tf = $indexValue->jumlah;
            $id = $indexValue->id;

            $NTerm = IndexModel::where('term', $term)->count();

            $w = $tf * log($n / $NTerm);

            $resUpdateBobot = IndexModel::where('id', $id)->update([
                'bobot' => $w,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
