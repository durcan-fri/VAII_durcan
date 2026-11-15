<?php

namespace App\Controllers;

use App\Models\Material;
use App\Models\MaterialType;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class MaterialController
 *
 * Handles CRUD operations for owned materials and material types in warehouse inventory.
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
            $matchingTypes = MaterialType::getAll(
                '`title` LIKE ? OR `code` LIKE ?',
                ["%{$search}%", "%{$search}%"]
            );
            $typeIds = array_map(fn($t) => (int)$t->getId(), $matchingTypes);

            if (!empty($typeIds)) {
                $placeholders = implode(',', array_fill(0, count($typeIds), '?'));
                $params = array_merge($typeIds, ["%{$search}%"]);
                $materials = Material::getAll(
                    "`material_type_id` IN ($placeholders) OR `warehouse` LIKE ?",
                    $params,
                    'id ASC'
                );
            } else {
                $materials = Material::getAll(
                    '`warehouse` LIKE ?',
                    ["%{$search}%"],
                    'id ASC'
                );
            }
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

        $materialSuppliers = $material->getMaterialSuppliers();

        return $this->html([
            'material' => $material,
            'materialSuppliers' => $materialSuppliers,
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
        $material->setWarehouse('Hlavný');
        $material->setInStock(0);
        $material->setMinStock(0);

        $materialTypes = MaterialType::getAll(orderBy: 'title ASC');

        return $this->html([
            'material' => $material,
            'materialTypes' => $materialTypes,
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

        $materialTypes = MaterialType::getAll(orderBy: 'title ASC');

        return $this->html([
            'material' => $material,
            'materialTypes' => $materialTypes,
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

        $materialTypeId = (int)$request->value('material_type_id');
        $title = trim((string)$request->value('title'));
        $code = trim((string)$request->value('code'));
        $inStockRaw = $request->value('in_stock');
        $minStockRaw = $request->value('min_stock');
        $unit = trim((string)$request->value('unit'));
        $warehouse = trim((string)$request->value('warehouse'));
        $description = trim((string)$request->value('description'));

        $errors = [];

        if ($title === '') {
            $errors[] = 'Názov typu materiálu je povinný údaj.';
        }
        if ($code === '') {
            $errors[] = 'Kód typu materiálu je povinný údaj.';
        }
        if ($unit === '') {
            $errors[] = 'Merná jednotka je povinný údaj.';
        }
        if ($warehouse === '') {
            $errors[] = 'Sklad je povinný údaj.';
        }
        if ($inStockRaw === null || $inStockRaw === '' || !is_numeric($inStockRaw) || (int)$inStockRaw < 0) {
            $errors[] = 'Množstvo na sklade musí byť nezáporné číslo.';
        }
        if ($minStockRaw === null || $minStockRaw === '' || !is_numeric($minStockRaw) || (int)$minStockRaw < 0) {
            $errors[] = 'Minimálne množstvo na sklade musí byť nezáporné číslo.';
        }

        // Find or create / update MaterialType
        $materialType = null;
        if ($materialTypeId > 0) {
            $materialType = MaterialType::getOne($materialTypeId);
        } elseif ($material->getMaterialTypeId() !== null) {
            $materialType = MaterialType::getOne($material->getMaterialTypeId());
        }

        if (!$materialType && $code !== '') {
            $existing = MaterialType::getAll('`code` = ?', [$code]);
            if (!empty($existing)) {
                $materialType = $existing[0];
            }
        }

        if (!$materialType) {
            $materialType = new MaterialType();
        }

        $materialType->setTitle($title);
        $materialType->setCode($code);
        $materialType->setUnit($unit);
        if ($materialType->getDescription() === null || $materialType->getDescription() === '') {
            $materialType->setDescription($description);
        }

        if (!empty($errors)) {
            $viewName = $isEdit ? 'edit' : 'create';
            $materialTypes = MaterialType::getAll(orderBy: 'title ASC');
            return $this->html([
                'material' => $material,
                'materialTypes' => $materialTypes,
                'errors' => $errors,
                'isEdit' => $isEdit,
            ], $viewName);
        }

        $materialType->save();

        $material->setMaterialTypeId($materialType->getId());
        $material->setWarehouse($warehouse);
        $material->setInStock((int)$inStockRaw);
        $material->setMinStock((int)$minStockRaw);
        $material->setDescription($description);

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
