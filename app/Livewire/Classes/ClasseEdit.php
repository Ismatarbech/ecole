<?php
namespace App\Livewire\Classes;

use Livewire\Component;
use App\Models\Niveau;
use App\Models\AnneeScolaire;
use App\Models\Classe;

class ClasseEdit extends Component
{
    public $niveau_id;
    public $name;
    public $annee;

 public function mount($classe)
{
    $this->classe = Classe::findOrFail($classe);

    $this->name = $this->classe->name;
    $this->niveau_id = $this->classe->niveau_id;
    $this->annee = Niveau::all();
}


    public function saveClasse(Classe $classe)
    {
        $this->validate([
            'niveau_id' => 'string|required|max:255',
            'name' => 'required|string|max:255',
        ]);

   
        $classe->name = $this->name;
        $classe->niveau_id = $this->niveau_id;
    
        $classe->updateClasse();

       return redirect()->route('classe.index')->with('success', 'Classe créée avec succès.');
    }
    


    public function render()
    {
        $anneeScolaire = AnneeScolaire::where('status', 'active')->first();

        $anneecurrent = Niveau::where('annee_scolaire_id', $anneeScolaire->id)->get();
        return view('classes.classe-create',compact('anneecurrent'));
    }
}