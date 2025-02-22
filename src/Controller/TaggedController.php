<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tagged Controller
 *
 * @property \App\Model\Table\TaggedTable $Tagged
 */
class TaggedController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Tagged->find()
            ->contain(['Tags']);
        $tagged = $this->paginate($query);

        $this->set(compact('tagged'));
    }

    /**
     * View method
     *
     * @param string|null $id Tagged id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $tagged = $this->Tagged->get($id, ['contain' => ['Tags']]);
        $this->set(compact('tagged'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tagged = $this->Tagged->newEmptyEntity();
        if ($this->request->is('post')) {
            $tagged = $this->Tagged->patchEntity($tagged, $this->request->getData());
            if ($this->Tagged->save($tagged)) {
                $this->Flash->success(__('The tagged has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tagged could not be saved. Please, try again.'));
        }
        $tags = $this->Tagged->Tags->find('list', limit: 200)->all();
        $this->set(compact('tagged', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tagged id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $tagged = $this->Tagged->get($id, ['contain' => []]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tagged = $this->Tagged->patchEntity($tagged, $this->request->getData());
            if ($this->Tagged->save($tagged)) {
                $this->Flash->success(__('The tagged has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tagged could not be saved. Please, try again.'));
        }
        $tags = $this->Tagged->Tags->find('list', limit: 200)->all();
        $this->set(compact('tagged', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tagged id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tagged = $this->Tagged->get($id);
        if ($this->Tagged->delete($tagged)) {
            $this->Flash->success(__('The tagged has been deleted.'));
        } else {
            $this->Flash->error(__('The tagged could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
