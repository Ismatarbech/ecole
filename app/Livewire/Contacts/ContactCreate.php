<?php
 
namespace App\Livewire\Contacts;

use Livewire\Component;
use App\Models\Contact;


class ContactCreate extends Component
{
    public string $nom;
    public string $matricule;
    public string $niveau;
    public string $sujet;
    public string $reclammation;


      protected $rules = [
        'nom' => 'required|string|max:255',
        'matricule'=> 'required|string|max:255',
        'niveau'=> 'required|string|max:255',
        'sujet'=> 'required|string|max:255',
        'reclammation'=> 'required|string|max:255'
    ];

        public function saveContact()
        {
            $this->validate();

            Contact::create([
                'nom'=>$this->nom,
                'matricule'=>$this->matricule,
                'niveau'=>$this->niveau,
                'sujet'=>$this->sujet,
                'reclammation'=>$this->reclammation,
            ]);

        return redirect('contact.create');

        $this->reset(['nom','matricule','niveau','sujet','reclammation']);
    }


    public function render()
    {
         return view('contacts.contact-create');
    }
}