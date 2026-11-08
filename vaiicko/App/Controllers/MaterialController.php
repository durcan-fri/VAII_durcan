<?php

namespace App\Controllers;

use App\Models\Material;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class MaterialController
 *
 * Handles CRUD operations for materials in warehouse inventory.
 *
 * @package App\Controllers
 */
class MaterialController extends BaseController
{
    /**
     * Authorizes controller actions.
     *
     * @param Request $request
     * @param string $action
     * @return bool
     */
    public function authorize(Request $request, string $action): bool
    {
        return true;
    }

    /**
     * Default action, delegates to material listing.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->material($request);
    }

    /**
     * Displays list of materials from the database (Read - List).
     *
     * @param Request $request
     * @return Response
     */
    public function material(Request $request): Response
    {
        $search = trim((string)$request->value('search'));

        if ($search !== '') {
            $materials = Material::getAll(
                '`title` LIKE ? OR `code` LIKE ? OR `warehouse` LIKE ? OR `status` LIKE ?',
                ["%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%"],
                'id ASC'
            );
        } else {
            $materials = Material::getAll(orderBy: 'id ASC');
        }

        return $this->html([
            'materials' => $materials,
            'search' => $search,
        ], 'material');
    }

    /**
     * Displays detail of a specific material (Read - Single).
     *
     * @param Request $request
     * @return Response
     */
    public function show(Request $request): Response
    {
        $id = (int)$request->value('id');
        $material = $id > 0 ? Material::getOne($id) : null;

        if (!$material) {
            return $this->redirect($this->url('material.material'));
        }

        return $this->html([
            'material' => $material,
        ], 'show');
    }

    /**
     * Alias for show action.
     *
     * @param Request $request
     * @return Response
     */
    public function detail(Request $request): Response
    {
        return $this->show($request);
    }

    /**
     * Displays form for creating a new material (Create - Form).
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $material = new Material();
        $material->setUnit('ks');
        $material->setWarehouse('Hlavný');
        $material->setStatus('Aktívny');
        $material->setInStock(0);

        return $this->html([
            'material' => $material,
            'errors' => [],
            'isEdit' => false,
        ], 'create');
    }

    /**
     * Displays form for editing an existing material (Update - Form).
     *
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request): Response
    {
        $id = (int)$request->value('id');
        $material = $id > 0 ? Material::getOne($id) : null;

        if (!$material) {
            return $this->redirect($this->url('material.material'));
        }

        return $this->html([
            'material' => $material,
            'errors' => [],
            'isEdit' => true,
        ], 'edit');
    }

    /**
     * Saves material to the database (Create / Update - Process).
     *
     * @param Request $request
     * @return Response
     */
    public function save(Request $request): Response
    {
        $id = $request->value('id');
        $material = null;
        $isEdit = false;

        if (!empty($id)) {
            $material = Material::getOne((int)$id);
            if ($material) {
                $isEdit = true;
            }
        }

        if (!$material) {
            $material = new Material();
        }

        $title = trim((string)$request->value('title'));
        $code = trim((string)$request->value('code'));
        $inStockRaw = $request->value('in_stock');
        $unit = trim((string)$request->value('unit'));
        $warehouse = trim((string)$request->value('warehouse'));
        $status = trim((string)$request->value('status'));
        $description = trim((string)$request->value('description'));

        $errors = [];

        if ($title === '') {
            $errors[] = 'Názov materiálu je povinný údaj.';
        }
        if ($code === '') {
            $errors[] = 'Kód materiálu je povinný údaj.';
        }
        if ($inStockRaw === null || $inStockRaw === '' || !is_numeric($inStockRaw) || (int)$inStockRaw < 0) {
            $errors[] = 'Množstvo na sklade musí byť nezáporné číslo.';
        }
        if ($unit === '') {
            $errors[] = 'Merná jednotka je povinný údaj.';
        }
        if ($warehouse === '') {
            $errors[] = 'Sklad je povinný údaj.';
        }
        if ($status === '') {
            $errors[] = 'Stav materiálu je povinný údaj.';
        }

        $material->setTitle($title);
        $material->setCode($code);
        $material->setInStock((int)$inStockRaw);
        $material->setUnit($unit);
        $material->setWarehouse($warehouse);
        $material->setStatus($status);
        $material->setDescription($description);

        if (!empty($errors)) {
            $viewName = $isEdit ? 'edit' : 'create';
            return $this->html([
                'material' => $material,
                'errors' => $errors,
                'isEdit' => $isEdit,
            ], $viewName);
        }

        $material->save();

        return $this->redirect($this->url('material.material'));
    }

    /**
     * Deletes a material from the database (Delete - Process).
     *
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request): Response
    {
        $id = (int)$request->value('id');

        if ($id > 0) {
            $material = Material::getOne($id);
            if ($material) {
                $material->delete();
            }
        }

        return $this->redirect($this->url('material.material'));
    }
}
