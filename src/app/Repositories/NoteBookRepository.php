<?php

namespace App\Repositories;

use App\Collections\NoteBookCollection;
use App\Models\NoteBook;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NoteBookRepository
{
    /**
     * Метод для получения всех записей из БД
     * 
     * @return NoteBookCollection
     */
    public function getAll(): NoteBookCollection
    {
        return NoteBook::all();
    }

    /**
     * Метод для получения одной записи из БД
     *
     * @param int $id
     *
     * @return NoteBook|null
     */
    public function getById(int $id): ?NoteBook
    {
        return NoteBook::query()->where('id', '=', $id)->first();
    }

    /**
     * Метод для добавления записи в БД
     *
     * @param array $data
     *
     * @return bool
     */
    public function add(array $data): bool
    {
        return NoteBook::insert($data);   
    }

    /**
     * Метод для обновления записи в БД
     *
     * @param int $id
     * @param array $data
     *
     * @return bool
     * 
     * @throws ModelNotFoundException
     */
    public function update(int $id, array $data): bool
    {
        $noteBook = $this->getById($id);
        if ($noteBook === null) {
            throw new ModelNotFoundException('Record not found');
        }

        return $noteBook->update($data);   
    }

    /**
     * Метод для удаления записи из БД
     *
     * @param int $id
     *
     * @return bool|null
     * 
     * @throws ModelNotFoundException
     */
    public function delete(int $id): ?bool
    {
        if ($id <= 0) {
            return false;
        }

        $noteBook = $this->getById($id);
        if ($noteBook === null) {
            throw new ModelNotFoundException('Record not found');
        }

        return $noteBook->delete();   
    }
}
