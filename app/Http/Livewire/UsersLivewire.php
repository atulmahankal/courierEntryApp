<?php

// https://laracasts.com/discuss/channels/livewire/livewire-form-validation-conditional-validation

namespace App\Http\Livewire;

use App\Functions\customeFunctions;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UsersLivewire extends Component
{
  use WithPagination;

  public $pagination = 15;
  public $search = '';
  public $checked = [];
  public $sortColumn = 'id';
  public $sortOrder = 'asc';
  public $item, $password, $action, $total, $filterName, $filterEmail, $selectPage, $importFile;

  protected $paginationTheme = 'bootstrap';
  protected $rules = [];

	public function __construct()
	{
		/**
		 * authenticate route.
		 */
    //  return abort(401);
	}

  public function mount()
  {
    $this->resetAll();
  }

  public function resetAll($includeCheck = false)
  {
    $this->item = new User();
    $this->action = 'add';
    $this->password = $this->selectPage = $this->filterName = $this->filterEmail = null;
    $this->rules = $this->rules();
    $this->resetErrorBag();
    if($includeCheck){
      $this->checked = [];
    }
  }

  public function getDataProperty(){
    $search = '%'.trim($this->search).'%';
    return User::orderBy($this->sortColumn,$this->sortOrder)
      ->where(function($query) use ($search){
        $query->where('name', 'like', $search)
          ->orWhere('email', 'like', $search);
      })
      ->where(function($query){
        customeFunctions::whereIn($query,$this->filterName,'name');
      })
      ->where(function($query){
        customeFunctions::whereIn($query,$this->filterEmail,'email');
      });
  }

  public function getPaginatedDataProperty(){
    return $this->data->paginate($this->pagination);
  }

  public function render()
  {
    $this->total = User::count();
    return view('livewire.users', ['records' => $this->paginatedData]);
  }

  public function showModal(User $item, $action)
  {
    $this->action = $action;
    $this->item = $item;
    $this->resetErrorBag();
    // $this->dispatchBrowserEvent('open-model');
  }
  
  function rules() {
		if ($this->item?->id) {
			$validator = [
				'item.email' => ['required', 'string', 'email', 'unique:users,email,' . $this->item->id . ',id'],
			];
		} else {
			$validator = [
				'item.email' => ['required', 'string', 'email', 'unique:users,email'],
				'password' => ['required', 'string', 'min:6', 'max:12'],	//$this->passwordRules(),
				//'password' => ['required', 'string', Rule::when(true, ['min:5', 'confirmed'])],
			];
		}
		$validatorComman = [
      'item.name' => 'required|string|min:6',
      'item.*' => 'nullable',
		];

    return array_merge($validator, $validatorComman);
  }
 
  protected $messages = [
    'item.*.required' => 'The :attribute cannot be empty.',
  ];

  protected $validationAttributes = [
    'item.name' => 'Name',
    'item.email' => 'Email address',
    'password' => 'Password',
  ];
 
  // public function updatingSearch()     //single field
  public function updating($propertyName)
  {
    /**
     * use to update pagination on search
     */
    if(
      $propertyName == 'search'
      || $propertyName == 'filterName'
      || $propertyName == 'filterEmail'
    ){
      $this->resetPage();
      // $filter = $this->data->where('id','!=',auth()->user()->id)->pluck('id')->map(fn($item) => (string) $item)->toArray();
      // $this->checked = array_values(array_intersect($this->checked, $filter));
      $this->checked = [];
    }
  }
 
  public function updated($propertyName)  // Real Time Validation
  {
    if($propertyName == 'item.name'){
      $this->item->name = ucwords($this->item->name);
    }
  }

  public function closeModal()
  {
    $this->dispatchBrowserEvent('close-model');
    $this->resetAll();
  }

  public function submit()
  {
    $this->validate();
    if($this->password){
      $this->item->password = Hash::make($this->password);
    }
    $this->item->save();
    // session()->flash('message','Record Saved Successfully.');
    $this->dispatchBrowserEvent('toast',[
      'title' => ucfirst($this->action). " User",
      'message' => 'Record Saved Successfully.',
    ]);
    $this->closeModal();
  }

  public function deleteModal(User $item)
  {
    $this->checked = array_values(array_diff($this->checked, [$item->id]));
    $this->item = $item;
    $this->item->delete();
    // session()->flash('message','Record Deleted Successfully.');
    $this->dispatchBrowserEvent('toast',[
      'title' => "Delete User",
      'message' => 'Record Deleted Successfully.',
    ]);
    $this->closeModal();
  }

  public function sort($column){
    if($this->sortColumn == $column){
      if($this->sortOrder == 'asc'){
        $this->sortOrder = 'desc';
      } else {
        $this->sortOrder = 'asc';
      }
    } else {
      $this->sortColumn = $column;
      // dd($this->sortColumn, $column);
      $this->sortOrder = 'asc';
    }
  }

  public function isChecked($id)
  {
    return in_array($id, $this->checked);
  }

  public function updatedSelectPage($value){
    if($value){
      $items = clone $this->paginatedData;
      // $this->checked = $items->where('id','!=',auth()->user()->id)->pluck('id')->map(fn($item) => (string) $item)->toArray();
      $this->checked = $items->pluck('id')->map(fn($item) => (string) $item)->toArray();
    } else {
      $this->checked = [];
    }
  }

  public function updatedChecked(){
    $this->selectPage = null;
  }

  public function selectAll(){
    $items = clone $this->data;
    // $this->checked = $items->where('id','!=',auth()->user()->id)->pluck('id')->map(fn($item) => (string) $item)->toArray();
    $this->checked = $items->pluck('id')->map(fn($item) => (string) $item)->toArray();
  }
  
  public function deleteChecked()
  {
    $deleting = array_values(array_diff($this->checked, [auth()->user()->id]));
    User::whereKey($deleting)->delete();
    $this->resetAll(true);
    // session()->flash('message','Record Deleted Successfully.');
    $this->dispatchBrowserEvent('toast',[
      'title' => "Delete Users",
      'message' => 'Record Deleted Successfully.',
    ]);
  }

  public function exportChecked() 
  {
    return (new UsersExport($this->checked))->download('Users.xlsx');
  }

  public function import(Request $request)
  {
    Excel::import(new UsersImport, $request->file('import_file'));
    return redirect()->back();
    // $this->dispatchBrowserEvent('toast',[
    //   'title' => "Import User",
    //   'message' => 'File Imported Successfully.',
    // ]);
  }
}
