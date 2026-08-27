<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Users\UserIndex;
use App\Livewire\Users\UserCreate;
use App\Livewire\Users\UserEdit;


use App\Livewire\Roles\RoleIndex;
use App\Livewire\Roles\RoleCreate;
use App\Livewire\Roles\RoleEdit;

use App\Livewire\Inscriptions\InscriptionCreate;
use App\Livewire\Inscriptions\InscriptionIndex;
use App\Livewire\Inscriptions\InscriptionEdit;
use App\Livewire\Inscriptions\InscriptionDetail;
use App\Livewire\Inscriptions\InscriptionScolarite;
use App\Livewire\Inscriptions\InscriptionCarte;

use App\Livewire\Permissions\PermissionIndex;
use App\Livewire\Permissions\PermissionCreate;
use App\Livewire\Permissions\PermissionEdit;

use App\Livewire\Etablissements\EtablissementIndex;
use App\Livewire\Etablissements\EtablissementCreate;
use App\Livewire\Etablissements\EtablissementEdit;


use App\Livewire\Classes\ClasseIndex;
use App\Livewire\Classes\ClasseCreate;
use App\Livewire\Classes\ClasseEdit;

use App\Livewire\Bulletins\BulletinIndex;
use App\Livewire\Bulletins\BulletinCreate;
use App\Livewire\Bulletins\BulletinEdit;

use App\Livewire\Profiles\ProfileIndex;
use App\Livewire\Profiles\ProfileCreate;
use App\Livewire\Profiles\ProfileEdit;

use App\Livewire\Niveaux\NiveauxIndex;
use App\Livewire\Niveaux\NiveauxCreate;
use App\Livewire\Niveaux\NiveauxEdit;

use App\Livewire\Paiements\PaiementIndex;
use App\Livewire\Paiements\PaiementCreate;
use App\Livewire\Paiements\PaiementEdit;

use App\Livewire\Contacts\ContactIndex;
use App\Livewire\Contacts\ContactCreate;
use App\Livewire\Contacts\ContactEdit;

use App\Livewire\AnneeScolaires\AnneeScolaireIndex;
use App\Livewire\AnneeScolaires\AnneeScolaireCreate;
use App\Livewire\AnneeScolaires\AnneeScolaireEdit;

use App\Livewire\Notes\NoteIndex;
use App\Livewire\Notes\NoteCreate;
use App\Livewire\Notes\NoteEdit;

use App\Livewire\Matieres\MatiereIndex;
use App\Livewire\Matieres\MatiereCreate;
use App\Livewire\Matieres\MatiereEdit;
use App\Http\Controllers\EleveDocumentController;
use App\Http\Controllers\DashboardController;



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});



// les utilisateurs

Route::get('etablissements', EtablissementIndex::class)->middleware(['auth','can:view_etablissements','can:view_any_etablissements'])->name('etablissement.index');
Route::get('etablissements/create', EtablissementCreate::class)->middleware(['auth'])->name('etablissement.create');
Route::get('etablissements/{etablissement}/edit', EtablissementEdit::class)->middleware(['auth','can:update_etablissements'])->name('etablissement.edit');


Route::get('users', UserIndex::class)->middleware(['auth','can:view_users','can:view_any_users'])->name('users.index');
Route::get('users/create', UserCreate::class)->middleware(['auth'])->name('users.create');
Route::get('users/{user}/edit', UserEdit::class)->middleware(['auth','can:update_users'])->name('users.edit');


Route::get('notes', NoteIndex::class)->middleware(['auth','can:view_notes','can:view_any_notes'])->name('note.index');
Route::get('notes/create', NoteCreate::class)->middleware(['auth'])->name('note.create');
Route::get('notes/{note}/edit', NoteEdit::class)->middleware(['auth','can:update_notes'])->name('note.update');



Route::get('matieres', MatiereIndex::class)->middleware(['auth','can:view_matieres','can:view_any_matieres'])->name('matiere.index');
Route::get('matieres/create', MatiereCreate::class)->middleware(['auth'])->name('matiere.create');
Route::get('matieres/{matiere}/edit', MatiereEdit::class)->middleware(['auth','can:update_matieres'])->name('matiere.update');

Route::get('roles', RoleIndex::class)->middleware(['auth','can:view_roles','can:view_any_roles'])->name('roles.index');
Route::get('roles/create', RoleCreate::class)->middleware(['auth'])->name('roles.create');
Route::get('roles/{role}/edit', RoleEdit::class)->middleware(['auth','can:update_roles'])->name('roles.edit');

Route::get('permissions', PermissionIndex::class)->middleware(['auth','can:view_permissions','can:view_any_permissions'])->name('permissions.index');
Route::get('permissions/create', PermissionCreate::class)->middleware(['auth'])->name('permissions.create');
Route::get('permissions/{permission}/edit', PermissionEdit::class)->middleware(['auth','can:update_permissions'])->name('permissions.edit');

Route::get('inscriptions/create',InscriptionCreate::class)->middleware(['auth','can:view_inscriptions','can:view_any_inscriptions'])->name('inscriptions.create');
Route::get('inscriptions',InscriptionIndex::class)->middleware(['auth','can:view_inscriptions','can:view_any_inscriptions'])->name('inscription.index');
Route::get('inscriptions/{eleve}/edit', InscriptionEdit::class)->middleware(['auth','can:update_inscriptions'])->name('inscription.edit');
Route::get('inscriptions/{id}/detail', InscriptionDetail::class)->middleware(['auth','can:detail_inscriptions'])->name('inscription.detail');
Route::get('inscriptions/{id}/scolarite', InscriptionScolarite::class)->middleware(['auth','can:scolarite_inscriptions'])->name('inscription.scolarite');
Route::get('inscriptions/{id}/carte', InscriptionCarte::class)->middleware(['auth','can:scolarite_inscriptions'])->name('inscription.carte');
Route::get('inscriptions/{eleve}/pdf/fiche', [EleveDocumentController::class, 'fiche'])->middleware(['auth','can:detail_inscriptions'])->name('inscription.pdf.fiche');
Route::get('inscriptions/{eleve}/pdf/bulletin', [EleveDocumentController::class, 'bulletin'])->middleware(['auth','can:detail_inscriptions'])->name('inscription.pdf.bulletin');
Route::get('inscriptions/{eleve}/pdf/carte', [EleveDocumentController::class, 'carte'])->middleware(['auth','can:scolarite_inscriptions'])->name('inscription.pdf.carte');


Route::get('bulletins', BulletinIndex::class)->middleware(['auth','can:view_bulletins','can:view_any_bulletins'])->name('bulletins.index');
Route::get('bulletins/create', BulletinCreate::class)->middleware(['auth'])->name('bulletins.create');
Route::get('bulletins/{bulletin}/edit', BulletinEdit::class)->middleware(['auth','can:update_bulletins'])->name('bulletins.edit');

Route::get('profiles', ProfileIndex::class)->middleware(['auth'])->name('profile.index');
//Route::get('profiles/create', ProfileCreate::class)->middleware(['auth'])->name('profile.create');
//Route::get('profiles/{profile}/edit', ProfileEdit::class)->middleware(['auth'])->name('profile.edit');

Route::get('niveaux', niveauxIndex::class)->middleware(['auth','can:view_niveaux','can:view_any_niveaux'])->name('niveaux.index');
Route::get('niveaux/create', niveauxCreate::class)->middleware(['auth'])->name('niveaux.create');
Route::get('niveaux/{niveau}/edit', niveauxEdit::class)->middleware(['auth','can:update_niveaux'])->name('niveaux.edit');


Route::get('anneescolaire', AnneeScolaireIndex::class)->middleware(['auth','can:view_annee_scolaire','can:view_any_annee_scolaire'])->name('anneescolaire.index');
Route::get('anneescolaire/create', AnneeScolaireCreate::class)->middleware(['auth'])->name('anneescolaire.create');
Route::get('anneescolaire/{anneescolaire}/edit', AnneeScolaireEdit::class)->middleware(['auth','can:update_annee_scolaire'])->name('anneescolaire.edit');

Route::get('classes', ClasseIndex::class)->middleware(['auth','can:view_classes','can:view_any_classes'])->name('classe.index');
Route::get('classes/create', ClasseCreate::class)->middleware(['auth'])->name('classe.create');
Route::get('classes/{classe}/edit', ClasseEdit::class)->middleware(['auth','can:update_classes'])->name('classe.edit');

Route::get('contacts', ContactIndex::class)->middleware('auth','can:view_contacts','can:view_any_contacts')->name('contact.index');
Route::get('contacts/create', ContactCreate::class)->middleware(['auth'])->name('contact.create');
Route::get('contacts/{contact}/edit', ContactEdit::class)->middleware(['auth','can:update_contact'])->name('contact.edit');


Route::get('paiements',paiementIndex::class)->middleware(['auth','can:view_paiements','can:view_any_paiements'])->name('paiement.index');
Route::get('paiements/create',PaiementCreate::class)->middleware(['auth'])->name('paiement.create');
Route::get('paiements/{paiement}/edit',PaiementEdit::class)->middleware(['auth','can:update_paiements'])->name('inscription.edit');


Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/admin/settings', [SettingController::class, 'index']);
});

require __DIR__.'/settings.php';
