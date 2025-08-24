<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Properties Controller
 *
 * @property \App\Model\Table\PropertiesTable $Properties
 */
class PropertiesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
   public function index()
    {
        $query = $this->Properties->find();
        $search = strtolower(trim((string)$this->request->getQuery('q', '')));

        if (!empty($search)) {
            $conditions = $this->buildSearchConditions($search);

            $query->where(function ($exp) use ($conditions) {
                return $exp->or($conditions);
            });

            if (preg_match('/(\d+)\s*sqft/i', $search, $matches)) {
                $query->orderAsc('ABS(sqft - ' . (int)$matches[1] . ')');
            }
        }

        $properties = $this->paginate($query);
        $this->set(compact('properties'));
    }

    private function buildSearchConditions(string $search): array
    {
        $conditions = [
            ['LOWER(title) LIKE' => "%$search%"],
            ['LOWER(city) LIKE'  => "%$search%"],
        ];

        if (preg_match('/(\d+)\s*bed/i', $search, $matches)) {
            $conditions[] = ['beds' => (int)$matches[1]];
        }

        if (preg_match('/(\d+)\s*bath/i', $search, $matches)) {
            $conditions[] = ['baths' => (int)$matches[1]];
        }

        if (preg_match('/(\d+)\s*sqft/i', $search, $matches)) {
            $conditions[] = ['sqft' => (int)$matches[1]];
            $conditions[] = ['sqft >=' => (int)$matches[1]];
        }

        if (preg_match('/[\$]?([\d,]+)/', $search, $matches)) {
            $price = (int)str_replace(',', '', $matches[1]);
            $conditions[] = ['price <=' => $price];
        }


        return $conditions;
    }







    /**
     * View method
     *
     * @param string|null $id Property id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $property = $this->Properties->get($id, contain: []);
        $this->set(compact('property'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $property = $this->Properties->newEmptyEntity();
        if ($this->request->is('post')) {
            $property = $this->Properties->patchEntity($property, $this->request->getData());
            if ($this->Properties->save($property)) {
                $this->Flash->success(__('The property has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The property could not be saved. Please, try again.'));
        }
        $this->set(compact('property'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Property id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $property = $this->Properties->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $property = $this->Properties->patchEntity($property, $this->request->getData());
            if ($this->Properties->save($property)) {
                $this->Flash->success(__('The property has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The property could not be saved. Please, try again.'));
        }
        $this->set(compact('property'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Property id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $property = $this->Properties->get($id);
        if ($this->Properties->delete($property)) {
            $this->Flash->success(__('The property has been deleted.'));
        } else {
            $this->Flash->error(__('The property could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
