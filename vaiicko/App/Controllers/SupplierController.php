<?php

namespace App\Controllers;

use App\Models\MaterialSupplier;
use App\Models\MaterialType;
use App\Models\Supplier;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

/**
 * Class SupplierController
 *
 * Handles supplier listing, detail, management, and assigning material_supplier data.
 *
 * @package App\Controllers
 */
class SupplierController extends BaseController
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
     * Default action, delegates to supplier listing.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->supplier($request);
    }

    /**
     * Displays list of suppliers with optional search filtering.
     *
     * @param Request $request
     * @return Response
     */
    public function supplier(Request $request): Response
    {
        $search = trim((string)$request->value('search'));

        if ($search !== '') {
            $suppliers = Supplier::getAll(
                '`name` LIKE ? OR `address` LIKE ? OR `email` LIKE ? OR `phone` LIKE ? OR `ico` LIKE ?',
                ["%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%", "%{$search}%"],
                'id ASC'
            );
        } else {
            $suppliers = Supplier::getAll(orderBy: 'id ASC');
        }

        return $this->html([
            'suppliers' => $suppliers,
            'search' => $search,
        ], 'supplier');
    }

    /**
     * Displays detail of a specific supplier and all materials they provide,
     * with form to add/edit material_supplier records.
     *
     * @param Request $request
     * @return Response
     */
    public function show(Request $request): Response
    {
        $id = (int)$request->value('id');
        $supplier = $id > 0 ? Supplier::getOne($id) : null;

        if (!$supplier) {
            return $this->redirect($this->url('supplier.supplier'));
        }

        $materialSuppliers = $supplier->getMaterialSuppliers();
        $materialTypes = MaterialType::getAll(orderBy: 'title ASC');

        $editMsId = (int)$request->value('edit_ms_id');
        $editMaterialSupplier = null;
        if ($editMsId > 0) {
            $editMaterialSupplier = MaterialSupplier::getOne($editMsId);
            // Verify this relation belongs to the current supplier
            if ($editMaterialSupplier && $editMaterialSupplier->getSupplierId() !== $supplier->getId()) {
                $editMaterialSupplier = null;
            }
        }

        return $this->html([
            'supplier' => $supplier,
            'materialSuppliers' => $materialSuppliers,
            'materialTypes' => $materialTypes,
            'editMaterialSupplier' => $editMaterialSupplier,
            'msErrors' => [],
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
     * Displays form for creating a new supplier.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $supplier = new Supplier();

        return $this->html([
            'supplier' => $supplier,
            'errors' => [],
            'isEdit' => false,
        ], 'create');
    }

    /**
     * Displays form for editing an existing supplier.
     *
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request): Response
    {
        $id = (int)$request->value('id');
        $supplier = $id > 0 ? Supplier::getOne($id) : null;

        if (!$supplier) {
            return $this->redirect($this->url('supplier.supplier'));
        }

        return $this->html([
            'supplier' => $supplier,
            'errors' => [],
            'isEdit' => true,
        ], 'edit');
    }

    /**
     * Saves supplier to the database (Create / Update).
     *
     * @param Request $request
     * @return Response
     */
    public function save(Request $request): Response
    {
        $id = $request->value('id');
        $supplier = null;
        $isEdit = false;

        if (!empty($id)) {
            $supplier = Supplier::getOne((int)$id);
            if ($supplier) {
                $isEdit = true;
            }
        }

        if (!$supplier) {
            $supplier = new Supplier();
        }

        $name = trim((string)$request->value('name'));
        $address = trim((string)$request->value('address'));
        $email = trim((string)$request->value('email'));
        $phone = trim((string)$request->value('phone'));
        $ico = trim((string)$request->value('ico'));
        $description = trim((string)$request->value('description'));

        $errors = [];

        if ($name === '') {
            $errors[] = 'Názov dodávateľa je povinný údaj.';
        }
        if ($address === '') {
            $errors[] = 'Adresa dodávateľa je povinný údaj.';
        }
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'E-mailová adresa nemá platný formát.';
        }

        $supplier->setName($name);
        $supplier->setAddress($address);
        $supplier->setEmail($email !== '' ? $email : null);
        $supplier->setPhone($phone !== '' ? $phone : null);
        $supplier->setIco($ico !== '' ? $ico : null);
        $supplier->setDescription($description !== '' ? $description : null);

        if (!empty($errors)) {
            $viewName = $isEdit ? 'edit' : 'create';
            return $this->html([
                'supplier' => $supplier,
                'errors' => $errors,
                'isEdit' => $isEdit,
            ], $viewName);
        }

        $supplier->save();

        return $this->redirect($this->url('supplier.show', ['id' => $supplier->getId()]));
    }

    /**
     * Deletes a supplier from the database.
     *
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request): Response
    {
        $id = (int)$request->value('id');

        if ($id > 0) {
            $supplier = Supplier::getOne($id);
            if ($supplier) {
                $supplier->delete();
            }
        }

        return $this->redirect($this->url('supplier.supplier'));
    }

    /**
     * Sets / updates material_supplier data for a supplier.
     *
     * @param Request $request
     * @return Response
     */
    public function saveMaterial(Request $request): Response
    {
        $supplierId = (int)$request->value('supplier_id');
        $supplier = $supplierId > 0 ? Supplier::getOne($supplierId) : null;

        if (!$supplier) {
            return $this->redirect($this->url('supplier.supplier'));
        }

        $msId = (int)$request->value('material_supplier_id');
        $materialTypeId = (int)$request->value('material_type_id');
        $priceRaw = str_replace(',', '.', trim((string)$request->value('price_per_unit')));
        $stockRaw = trim((string)$request->value('stock'));
        $deliveryDaysRaw = trim((string)$request->value('delivery_days'));

        $errors = [];

        if ($materialTypeId <= 0) {
            $errors[] = 'Vyberte typ materiálu.';
        } else {
            $matType = MaterialType::getOne($materialTypeId);
            if (!$matType) {
                $errors[] = 'Zvolený typ materiálu neexistuje.';
            }
        }

        if ($priceRaw === '' || !is_numeric($priceRaw) || (float)$priceRaw <= 0) {
            $errors[] = 'Cena za jednotku musí byť kladné číslo väčšie ako 0.';
        }

        if ($stockRaw === '' || !is_numeric($stockRaw) || (int)$stockRaw < 0) {
            $errors[] = 'Zásoba u dodávateľa musí byť nezáporné číslo (0 alebo viac).';
        }

        if ($deliveryDaysRaw === '' || !is_numeric($deliveryDaysRaw) || (int)$deliveryDaysRaw < 1) {
            $errors[] = 'Dodacia lehota musí byť aspoň 1 deň.';
        }

        $materialSupplier = null;
        if ($msId > 0) {
            $materialSupplier = MaterialSupplier::getOne($msId);
            if ($materialSupplier && $materialSupplier->getSupplierId() !== $supplier->getId()) {
                $materialSupplier = null;
            }
        }

        // If not editing by ID, check if relationship already exists
        if (!$materialSupplier && $materialTypeId > 0) {
            $existing = MaterialSupplier::getAll(
                '`supplier_id` = ? AND `material_type_id` = ?',
                [$supplier->getId(), $materialTypeId]
            );
            if (!empty($existing)) {
                $materialSupplier = $existing[0];
            }
        }

        if (!$materialSupplier) {
            $materialSupplier = new MaterialSupplier();
            $materialSupplier->setSupplierId($supplier->getId());
        }

        $materialSupplier->setMaterialTypeId($materialTypeId);
        $materialSupplier->setPricePerUnit((float)$priceRaw);
        $materialSupplier->setStock((int)$stockRaw);
        $materialSupplier->setDeliveryDays((int)$deliveryDaysRaw);

        if (!empty($errors)) {
            $materialSuppliers = $supplier->getMaterialSuppliers();
            $materialTypes = MaterialType::getAll(orderBy: 'title ASC');

            return $this->html([
                'supplier' => $supplier,
                'materialSuppliers' => $materialSuppliers,
                'materialTypes' => $materialTypes,
                'editMaterialSupplier' => $materialSupplier,
                'msErrors' => $errors,
            ], 'show');
        }

        $materialSupplier->save();

        return $this->redirect($this->url('supplier.show', ['id' => $supplier->getId()]));
    }

    /**
     * Removes a material_supplier association.
     *
     * @param Request $request
     * @return Response
     */
    public function deleteMaterial(Request $request): Response
    {
        $supplierId = (int)$request->value('supplier_id');
        $msId = (int)$request->value('id');

        if ($msId > 0) {
            $ms = MaterialSupplier::getOne($msId);
            if ($ms) {
                if ($supplierId <= 0) {
                    $supplierId = (int)$ms->getSupplierId();
                }
                $ms->delete();
            }
        }

        if ($supplierId > 0) {
            return $this->redirect($this->url('supplier.show', ['id' => $supplierId]));
        }

        return $this->redirect($this->url('supplier.supplier'));
    }
}
