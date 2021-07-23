<?php

namespace App\Controller;

use Pecee\Http\Response;
use Pecee\Http\Request;
use Rakit\Validation\Validator;
use App\Entity\{Ads, AdsView};
use App\Exception\ValidationFailedException;
use App\Service\AdsService;

class AdsController extends AbstractController
{
    private AdsService $adsService;

    private Validator $validator;
    
    public function __construct(AdsService $adsService, Validator $validator)
    {
        $this->adsService = $adsService;
        $this->validator = $validator;
    }

    public function create(Request $request): void
    {
        // тут можно написать обертку над request
        $data = $request->getInputHandler()->all();

        $this->validate($data, Ads::getValidationRules());

        $ads = new Ads($data['text'], $data['price'], $data['limit'], $data['banner']);

        $ads = $this->adsService->create($ads);

        $this->returnJsonResponse([
            'message' => 'ok',
            'code' => 200,
            'data' => $ads,
        ]);
    }

    public function update(Request $request, int $id): void
    {
        // тут можно написать обертку над request
        $data = $request->getInputHandler()->all();

        $this->validate($data, Ads::getValidationRules());

        $ads = $this->adsService->update($id, $data);

        $this->returnJsonResponse([
            'message' => 'ok',
            'code' => 200,
            'data' => $ads,
        ]);
    }

    public function getRelevant(): void
    {
        $ads = $this->adsService->getRelevant();

        $this->returnJsonResponse([
            'message' => 'ok',
            'code' => 200,
            'data' => $ads,
        ]);
    }

    /**
     * Валидация данных
     *
     * @param array $data Массив данных, которые нужно провалидировать
     * @param array $validationRules Правила валидации
     *
     * @throws ValidationfailedException
     *
     * @return void
     */
    protected function validate(array $data, array $validationRules): void
    {
        $validation = $this->validator->make($data, $validationRules);
        $validation->validate();

        if ($validation->fails()) {
            throw new ValidationFailedException($validation->errors->all(), 'Validation failed');
        }
    }
}