<?php

namespace App\Http\Controllers;

use App\Repositories\NoteBookRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class NoteBookController extends Controller
{
    public const OK = 200;
    public const CREATED = 201;
    public const BAD_REQUEST = 400;
    public const PATH_TO_IMAGES = '/uploads/images/';

    private NoteBookRepository $noteBookRepository;

    public function __construct(NoteBookRepository $noteBookRepository)
    {
        $this->noteBookRepository = $noteBookRepository;
    }

    public function index(): Response
    {
        /** @var NoteBookCollection $noteBooks  */
        $noteBooks = $this->noteBookRepository->getAll();

        if ($noteBooks->isNotEmpty()) {
            return response($noteBooks);    
        }

        return response()->noContent();

    }

    public function getOne(int $id): Response
    {
        /** @var NoteBook|null $noteBook  */
        $noteBook = $this->noteBookRepository->getById($id);

        if (is_null($noteBook)) {
            return response()->noContent();   
        }

        return response($noteBook);

    }

    public function add(Request $request, int $id = 0): Response
    {
        $body = $request->post();

        if (is_string($body) && is_null($body)) {
            return response('Check the request. Body must be an array', self::BAD_REQUEST);
        }

        try {
                $body = Validator::validate($body, $this->getRules());
             
                if (isset($item['birth_date'])) {
                    $item['birth_date'] = date('Y-m-d', strtotime($item['birth_date']));
                }

                if($request->hasFile('image')) {
                    $request->validate($this->getRulesForImages());

                    $file = $request->file('image');

                    if(!$file->isValid()) {
                        return response(['Invalid file upload'], self::BAD_REQUEST);
                    }

                    $path = public_path() . self::PATH_TO_IMAGES;
                    if (file_exists($path . $file->getClientOriginalName())) {
                        return response(['A file with that name already exists'], self::BAD_REQUEST);
                    }

                    if (!is_dir($path)) {
                        mkdir($path, 0755, true);
                    }
                    
                    $file->move($path, $file->getClientOriginalName());
                    $body['image'] = self::PATH_TO_IMAGES . $file->getClientOriginalName();
                }

                $body['updated_at'] = Carbon::now('utc')->toDateTimeString();

                if ($id === 0) {
                    $body['created_at'] = $body['updated_at'];
                    $this->noteBookRepository->add($body);
                    $status = self::CREATED;
                } else {
                    $this->noteBookRepository->update($id, $body);
                    $status = self::OK;
                }


        } catch (ValidationException $e) {
            return response(['error' => $e->getMessage()], self::BAD_REQUEST);
        } catch (ModelNotFoundException $e) {
            return response(['error' => $e->getMessage()], self::BAD_REQUEST);
        }catch (Exception $e) {
            Log::error($e->getMessage() . ' Trace: ' . $e->getTraceAsString());

            return response('Something were wrong', self::BAD_REQUEST);
        }

        return response(['status' => 'Ok'], $status);
    }

    public function delete(int $id): Response
    {
        $msg = 'The record was deleted';
        $status = $this::OK;

        try {
            $this->noteBookRepository->delete($id);
        } catch (ModelNotFoundException $e) {
            $msg = $e->getMessage();
            $status = $this::BAD_REQUEST; 
        } catch (Exception $e) {
            Log::error($e->getMessage());

            $msg = 'The record was not deleted';
            $status = $this::BAD_REQUEST;
        }

        return response($msg, $status);
    }

    private function getRules(): array
    {
        return [
            'name' => [
                'required',
                'max:255',
            ],
            'company' => [
                'max:255',
            ],
            'phone' => [
                'required',
                'max:20',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'birth_date' => [
                'date',
            ],
        ];
    }

    private function getRulesForImages(): array
    {
        return [
            'image' => [
                'image',
                'mimes:jpeg,png,jpg,svg',  
            ],
        ];
    }
}
