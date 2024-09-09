<?php

namespace App\Http\Controllers;

use App\Models\SuccessfulEmail;
use App\Services\ParseEmailContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuccessfulEmailController extends Controller
{
    // Método único para validação
    // Function to validate the fields of the successful_emails table
    protected function validateEmailData(array $data, $isUpdate = false)
    {
        $rules = [
            'affiliate_id' => 'required|integer',
            'envelope' => 'required|string',
            'from' => 'required|string|max:255',
            'subject' => 'required|string',
            'dkim' => 'nullable|string|max:255',
            'SPF' => 'nullable|string|max:255',
            'spam_score' => 'nullable|numeric',
            'email' => 'required|string', // Raw Email Payload
            'raw_text' => 'nullable|string', // Processed text of the email body
            'sender_ip' => 'nullable|string|max:50',
            'to' => 'required|string',
            'timestamp' => 'required|integer',
        ];

        // Se for uma atualização, torna os campos opcionais usando "sometimes"
        if ($isUpdate) {
            foreach ($rules as $field => $rule) {
                $rules[$field] = 'sometimes|' . $rule;
            }
        }

        return Validator::make($data, $rules);
    }

    /**
     * Get All (Return all records except deleted items)
     * GET /emails
     */
    public function index()
    {
        // Return all emails except deleted ones (soft delete)
        $successfulEmails = SuccessfulEmail::whereNull('deleted_at')->get();

        return response()->json($successfulEmails);
    }

    /**
     * Store (Creates a new record and processes it automatically)
     * POST /emails
     */
    public function store(Request $request)
    {
        // Validação
        $validator = $this->validateEmailData($request->all());

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Process the email content (plain text parse)
        $parser = new ParseEmailContent();
        $plainTextBody = $parser->extractBody($request->input('email'));
        $request->merge(['raw_text' => $plainTextBody]);

        // Cria o novo registro
        $successfulEmail = SuccessfulEmail::create($request->all());
        return response()->json($successfulEmail, 201); // 201 Created
    }

    /**
     * Get by ID (Search for a record by ID)
     * GET /emails/{id}
     */
    public function show($id)
    {
        // Search for the record by ID
        $successfulEmail = SuccessfulEmail::findOrFail($id);

        if (!$successfulEmail) {
            return response()->json(['message' => 'Email not found'], 404); // 404 Not Found
        }

        // Return the found record
        return response()->json($successfulEmail);
    }

    /**
     * Update (Update a record based on the passed ID)
     * PUT /emails/{id}
     */
    public function update(Request $request, $id)
    {
        // Busca o registro a ser atualizado
        $successfulEmail = SuccessfulEmail::findOrFail($id);

        // Valida os campos que foram enviados
        // Valida os dados do request, permitindo que campos não sejam obrigatórios
        $validator = $this->validateEmailData($request->all(), true);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Check if field email was submited to parse
        if ($request->has('email')) {
            // Process the email content (plain text parse)
            $parser = new ParseEmailContent();
            $plainTextBody = $parser->extractBody($request->input('email'));
            $request->merge(['raw_text' => $plainTextBody]);
        }

        // Atualiza apenas os campos que foram enviados
        $successfulEmail->update($request->only(array_keys($request->all())));

        return response()->json($successfulEmail); // 201 Updated
    }

    /**
     * Delete by ID (Soft delete a record based on ID)
     * DELETE /emails/{id}
     */
    public function destroy($id)
    {
        // Search for the record by ID
        $successfulEmail = SuccessfulEmail::findOrFail($id);

        if (!$successfulEmail) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        // Performs soft delete
        $successfulEmail->delete();

        return response()->json(['message' => 'Email deleted successfully']);
    }
}
