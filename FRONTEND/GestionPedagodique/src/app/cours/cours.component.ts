import { Component, OnInit, ViewChild } from '@angular/core';
import { CoursService } from './services/cour.service';
import { DonneesRegroupeesService } from './services/data.service';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { NgForm } from '@angular/forms';

@Component({
  selector: 'app-cours',
  templateUrl: './cours.component.html',
  styleUrls: ['./cours.component.css'],
})
export class CoursComponent implements OnInit {
  @ViewChild('monFormulaire') formulaire: NgForm | undefined;
  cours: any[] = [];
  classes: any[] = [];
  modules: any[] = [];
  semestres: any[] = [];
  professeurs: any[] = [];
  monFormulaire: FormGroup= new FormGroup({});
  sessionsExistantes: any[] = [];
  sallesDisponibles: number[] = [];

  errorMessage: string | null = null;
  salleOccupeeMessage = 'La salle est déjà occupée à ce moment-là.';
  salleReserveeMessage = 'La salle est déjà réservée pour une durée similaire.';
  quotaHoraireInsuffisantMessage = 'Le quota horaire du professeur est insuffisant.';

  messagesErreurs: any = {
    sessionExistanteOuSalleNonDisponible: {
      message: 'Session existante ou salle non disponible. Veuillez changer les détails.',
    },
  };

  constructor(
    private coursService: CoursService,
    private donneesService: DonneesRegroupeesService,
    private formBuilder: FormBuilder
  ) {
    this.formulaire = undefined;
  }

  afficherModal = false;
  vosDonnees: any = {
    date: '',
    heure_debut: '',
    heure_fin: '',
    etat: 'en cours',
    cour_id: 0,
    salle_id: 0,
  };

  ngOnInit(): void {
    this.coursService.getCours().subscribe(({ data }) => {
      this.cours = data;
    });

    this.donneesService.getClasses().subscribe((data: any) => {
      this.classes = data.classes;
    });

    this.donneesService.getModules().subscribe((data: any) => {
      this.modules = data.modules;
    });

    this.donneesService.getSemestres().subscribe((data: any) => {
      this.semestres = data.semestres;
    });

    this.donneesService.getProfesseurs().subscribe((data: any) => {
      this.professeurs = data.professeurs;
    });

    this.monFormulaire = this.formBuilder.group({
      professeur_id: ['', Validators.required],
      classe_id: ['', Validators.required],
      module_id: ['', Validators.required],
      semestre_id: ['', Validators.required],
      quota_horaire: ['', Validators.required],
    });
  }

  validationHeureDebut() {
    const heureDebutControl = this.monFormulaire.get('heure_debut');

    if (heureDebutControl) {
      const heureDebut = parseInt(heureDebutControl.value, 10);

      if (heureDebut < 8 || heureDebut >= 16) {
        heureDebutControl.setErrors({ invalidHour: true });
      } else {
        heureDebutControl.setErrors(null);
      }
    }
  }

  validationPersonnalisee() {
    const sessionExistante = this.sessionsExistantes.find((session) => {
      return (
        session.date === this.vosDonnees.date &&
        session.heure_debut === this.vosDonnees.heure_debut &&
        session.salle_id === this.vosDonnees.salle_id
      );
    });

    const salleDisponible = this.sallesDisponibles.includes(
      this.vosDonnees.salle_id
    );

    if (sessionExistante || !salleDisponible) {
      this.monFormulaire.setErrors({
        sessionExistanteOuSalleNonDisponible: true,
      });
    } else {
      this.monFormulaire.setErrors(null);
    }
  }

  onSubmit() {
    if (this.monFormulaire.invalid) {
      return;
    }

    const formData = this.monFormulaire.value;

    this.coursService.ajouterCours(formData).subscribe(
      (response) => {
        console.log('Cours ajouté avec succès !', response);
        this.errorMessage = '';
        this.cours.unshift(response);

        // Réinitialisez le formulaire
        this.formulaire?.resetForm();

        // Efface le message d'erreur après l'ajout
        setTimeout(() => {
          this.errorMessage = null;
        }, 2000);
      },
      (error) => {
        console.error("Erreur lors de l'ajout de la session :", error);

        if (error.error && error.error.message) {
          this.errorMessage = error.error.message;
        } else if (error.error && error.error.salleOccupee) {
          this.errorMessage = 'La salle est déjà occupée à ce moment-là.';
        } else if (error.error && error.error.salleReservee) {
          this.errorMessage = 'La salle est déjà réservée pour une durée similaire.';
        } else if (error.error && error.error.quotaHoraireInsuffisant) {
          this.errorMessage = 'Le quota horaire du professeur est insuffisant.';
        } else {
          this.errorMessage = 'Une erreur inattendue s\'est produite.';
        }

        setTimeout(() => {
          this.errorMessage = null;
        }, 2000);
      }
    );
  }

  getImageUrl(module: string): string {
    let imageUrl = '';
    switch (module) {
      case 'Angular':
        imageUrl =
          'https://repository-images.githubusercontent.com/49016322/13d16c00-613a-11e9-9b59-9d4b6e6cb483';
        break;
      case 'Laravel':
        imageUrl =
          'https://media.licdn.com/dms/image/D5612AQGrUk-Euq6J_w/article-cover_image-shrink_600_2000/0/1677780279349?e=2147483647&v=beta&t=OJ7_EgucF9GJPnzVn23mbaXtKdrf-kvDffVHGC-h38w';
        break;
      case 'java':
        imageUrl =
          'https://ubiqum.com/assets/uploads/2021/12/learn-java-with-ubiqum-logo.png';
        break;
      case 'Javascript':
        imageUrl =
          'https://miro.medium.com/v2/resize:fit:800/1*bthRXJ_FBspSEijOWIRM2A.png';
        break;
      case 'PHP':
        imageUrl =
          'https://kinsta.com/wp-content/uploads/2018/05/what-is-php-3-1.png';
        break;
      case 'FIGMA':
        imageUrl = 'https://www.leptidigital.fr/wp-content/uploads/2022/11/logo-figma.jpeg';
        break;
      case 'UML':
        imageUrl = 'https://venngage-wordpress.s3.amazonaws.com/uploads/2021/11/Use-Case-Diagram-Blog-Header.png';
        break;
      default:
        imageUrl = 'https://via.placeholder.com/150';
        break;
    }
    return imageUrl;
  }

  soumettreFormulaire() {
    // Soumettre le formulaire pour planifier une session
    if (this.monFormulaire.valid) {
      // Votre logique de planification de session ici

      // Réinitialiser les données du formulaire
      this.vosDonnees.date = '';
      this.vosDonnees.heure_debut = '';
      this.vosDonnees.heure_fin = '';
      this.vosDonnees.etat = 'en cours';
      this.vosDonnees.cour_id = 0;
      this.vosDonnees.salle_id = 0;

      // Cacher la boîte modale
      this.afficherModal = false;
    }
  }

  ouvrirModal(courId: number) {
    this.vosDonnees.cour_id = courId;
    this.afficherModal = true;
  }

  fermerModal() {
    this.vosDonnees.date = '';
    this.vosDonnees.heure_debut = '';
    this.vosDonnees.heure_fin = '';
    this.vosDonnees.etat = 'en cours';
    this.vosDonnees.cour_id = 0;
    this.vosDonnees.salle_id = 0;

    this.afficherModal = false;
  }
}
