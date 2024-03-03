<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVerify_documentRequest;
use App\Http\Requests\UpdateVerify_documentRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Verify_document;
use Illuminate\Http\Request;
use Flash;
use Response;

class Verify_documentController extends AppBaseController
{
    /**
     * Display a listing of the Verify_document.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var Verify_document $verifyDocuments */
        $verifyDocuments = Verify_document::all();

        return view('verify_documents.index')
            ->with('verifyDocuments', $verifyDocuments);
    }

    /**
     * Show the form for creating a new Verify_document.
     *
     * @return Response
     */
    public function create()
    {
        return view('verify_documents.create');
    }

    /**
     * Store a newly created Verify_document in storage.
     *
     * @param CreateVerify_documentRequest $request
     *
     * @return Response
     */
    public function store(CreateVerify_documentRequest $request)
    {
        $input = $request->all();

        /** @var Verify_document $verifyDocument */
        $verifyDocument = Verify_document::create($input);

        Flash::success('Verify Document Berhasil Disimpan.');

        return redirect(route('verifyDocuments.index'));
    }

    public static function simpanData($input)
    {

        $verifyDocument = Verify_document::create($input);

        return $verifyDocument;
    }

    /**
     * Display the specified Verify_document.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Verify_document $verifyDocument */
        $verifyDocument = Verify_document::find($id);

        if (empty($verifyDocument)) {
            Flash::error('Verify Document Tidak Ada');

            return redirect(route('verifyDocuments.index'));
        }

        return view('verify_documents.show')->with('verifyDocument', $verifyDocument);
    }

    public function verify($sn_document)
    {
        /** @var Verify_document $verifyDocument */
        $verifyDocument = Verify_document::where('serial_number',$sn_document)->first();

        if (empty($verifyDocument)) {
            return view('verify_documents.failed')->with('verifyDocument', $verifyDocument);
        }

        return view('verify_documents.success')->with('verifyDocument', $verifyDocument);
    }

    /**
     * Show the form for editing the specified Verify_document.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Verify_document $verifyDocument */
        $verifyDocument = Verify_document::find($id);

        if (empty($verifyDocument)) {
            Flash::error('Verify Document Tidak Ada');

            return redirect(route('verifyDocuments.index'));
        }

        return view('verify_documents.edit')->with('verifyDocument', $verifyDocument);
    }

    /**
     * Update the specified Verify_document in storage.
     *
     * @param int $id
     * @param UpdateVerify_documentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVerify_documentRequest $request)
    {
        /** @var Verify_document $verifyDocument */
        $verifyDocument = Verify_document::find($id);

        if (empty($verifyDocument)) {
            Flash::error('Verify Document Tidak Ada');

            return redirect(route('verifyDocuments.index'));
        }

        $verifyDocument->fill($request->all());
        $verifyDocument->save();

        Flash::success('Verify Document Berhasil Diubah.');

        return redirect(route('verifyDocuments.index'));
    }

    /**
     * Remove the specified Verify_document from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Verify_document $verifyDocument */
        $verifyDocument = Verify_document::find($id);

        if (empty($verifyDocument)) {
            Flash::error('Verify Document Tidak Ada');

            return redirect(route('verifyDocuments.index'));
        }

        $verifyDocument->delete();

        Flash::success('Verify Document Berhasil Dihapus.');

        return redirect(route('verifyDocuments.index'));
    }
}
