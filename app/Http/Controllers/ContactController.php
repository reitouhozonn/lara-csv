<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::select('contacts.*', 'c.name AS condition_name', 'd.name AS design_name')
            ->where('contacts.status', 1)
            ->leftJoin('conditions AS c', 'contacts.condition_id', '=', 'c.id')
            ->leftJoin('designs AS d', 'contacts.design_id', '=', 'd.id')
            ->orderBy('contacts.created_at', 'DESC')
            ->get('');

        return view('index', compact('contacts'));
    }

    public function csvExport(Request $request)
    {
        $post = $request->all();
        $response = new StreamedResponse(function () use ($request, $post) {

            $stream = fopen('php://output', 'w');
            $contact = new Contact();

            // 文字化け回避
            stream_filter_prepend($stream, 'convert.iconv.utf-8/cp932//TRANSLIT');

            // ヘッダー行を追加
            fputcsv($stream, $contact->csvHeader());

            $results = $contact->getCsvData($post['start_data'], $post['end_data']);

            if (empty($results[0])) {
                fputcsv($stream, [
                    'データが存在しませんした。',
                ]);
            } else {
                foreach ($results as $row) {
                    fputcsv($stream, $contact->csvRow($row));
                }
            }
            fclose($stream);
        });
        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('content_disposition', 'attachment; filename=' . $post['start_data'] . '~' . $post['end_data'] . 'お問い合わせ一覧.csv');

        return $response;
    }
}
