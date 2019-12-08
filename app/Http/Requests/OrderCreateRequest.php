<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\ParameterBag;

class OrderCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Modify phone number and trim all fields
     *
     * @return array
     */
    public function getOrderData():array
    {
        $data = [
            'restaurant_id' => $this->restaurant_id,
            'client_phone_number' => $this->client_phone_number,
            'client_name' => $this->client_name,
            'order_details' => $this->order_details,
        ];
        $data['client_phone_number'] = preg_replace('/[^0-9]/', '', $data['client_phone_number']);
        $data['client_phone_number'] = "+{$data['client_phone_number']}";
        $data = array_map('trim', $data);
        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'restaurant_id' => 'required|restaurantExists',
            'client_phone_number' => 'required|max:20',
            'client_name' => 'required|max:128',
            'order_details' => 'required|max:1000',
        ];
    }
}
