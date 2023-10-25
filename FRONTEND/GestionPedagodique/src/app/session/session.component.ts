import { Component, OnInit } from '@angular/core';
import { SessionService } from './services/session.service';
import { formatDate } from '@angular/common';
// import { Pipe, PipeTransform } from '@angular/core';

@Component({
  selector: 'app-session',
  templateUrl: './session.component.html',
  styleUrls: ['./session.component.css'],
})
export class SessionComponent {
  sessions!: any[];
  periodeDebut!: Date;
  periodeFin!: Date;
  estFiltrageParSemaine: boolean = true;
  page: number = 1; // Numéro de la page actuelle
  selectedFilter: string = 'last30days';
  data: any[] = [];
  selectedDate!: Date;
  selectedClass!: string;
  selectedMonth!: string;
  selectedProfessor!: string;
  filteredSessions: any[] = [];
  // itemsParPage: number = 10;
  filtre: string = '';
  // salles!: any[];
  afficherModal = false; // Pour afficher ou masquer la boîte modale
  vosDonnees: any = {
    date: '',
    heure_debut: '',
    heure_fin: '',
    etat: 'en cours',
    cour_id: 0,
    salle_id: 0,
  };
  donneesService: any;
  constructor(private session: SessionService) {}
  ngOnInit() {
    console.log('scnjscbcbvd');
    this.session.getSession().subscribe((data: any[]) => {
      this.sessions = data;
      console.log(data);
    });

    // this.filtrerSessionsParPeriode();
  }
  filterData() {
    const currentDate = new Date();
    let startDate: any = null;

    switch (this.selectedFilter) {
      case 'lastday':
        startDate = new Date(currentDate);
        startDate.setDate(currentDate.getDate() - 1);
        break;
      case 'last7days':
        startDate = new Date(currentDate);
        startDate.setDate(currentDate.getDate() - 7);
        break;
      case 'last30days':
        startDate = new Date(currentDate);
        startDate.setDate(currentDate.getDate() - 30);
        break;
      case 'lastmonth':
        startDate = new Date(
          currentDate.getFullYear(),
          currentDate.getMonth() - 1,
          1
        );
        break;
      case 'lastyear':
        startDate = new Date(currentDate.getFullYear() - 1, 0, 1);
        break;
      default:
        break;
    }

    if (startDate) {
      const filteredData = this.data.filter((item) => {
        const itemDate = new Date(item.date); // Supposons que la propriété de date soit "date"
        return itemDate >= startDate && itemDate <= currentDate;
      });

      // Utilisez les données filtrées comme nécessaire
      console.log(filteredData);
    }
  }
  onFilterChange(filter: string) {
    this.selectedFilter = filter;
    // Appeler la méthode de filtrage des données ici
    this.filterData();
  }
  soumettreFormulaire() {
    const dateFormatted = formatDate(this.vosDonnees.date, 'yy/MM/dd', 'en-US');
    this.session.ajouterSession(this.vosDonnees).subscribe((response: any) => {
      console.log(response);
      if (this.vosDonnees.etat === 'en cours') {
        const dddd =
          document.querySelector<HTMLTableCellElement>('bbbb')?.style.color !=
          'red';
      }

      this.afficherModal = false;
    });
  }

  annulerSession(session: { id: number; etat: string }) {
    this.session.annulerSession(session.id).subscribe(
      (response) => {
        // Gérez la réponse réussie (par exemple, mettez à jour la vue pour refléter l'annulation)
        session.etat = 'annulé'; // Mettez à jour l'état côté front-end
      },
      (error) => {
        // Gérez les erreurs
        console.error("Erreur lors de l'annulation de la session");
      }
    );
  }

  filtrerSessions() {
    if (!this.filtre) {
      return this.sessions;
    }

    const filtreLowerCase = this.filtre.toLowerCase();
    return this.sessions.filter((session) => {
      return (
        session.cours.professeur.nom_Complet
          .toLowerCase()
          .includes(filtreLowerCase) ||
        session.cours.classe.libelle.toLowerCase().includes(filtreLowerCase) ||
        session.date.toLowerCase().includes(filtreLowerCase)
      );
    });
  }

  filtrerSessionsParPeriode() {
    this.session.getSession().subscribe((data: any[]) => {
      this.sessions = data.filter((session) => {
        const dateSession = new Date(session.date);
        if (this.periodeDebut && this.periodeFin) {
          if (this.estFiltrageParSemaine) {
            // Filtrer par semaine
            const debutSemaine = new Date(this.periodeDebut);
            const finSemaine = new Date(this.periodeFin);
            finSemaine.setDate(finSemaine.getDate() + 7);
            return dateSession >= debutSemaine && dateSession < finSemaine;
          } else {
            // Filtrer par mois
            const debutMois = new Date(this.periodeDebut);
            const finMois = new Date(this.periodeFin);
            finMois.setMonth(finMois.getMonth() + 1);
            return dateSession >= debutMois && dateSession < finMois;
          }
        } else {
          // Si la période n'est pas sélectionnée, affiche toutes les sessions
          return true;
        }
      });

      this.page = 1; // Réinitialise la page à la première page
    });
  }

  // filtrerSessions(sessions: any[], filtre: string): any[] {
  //   if (!filtre) {
  //     return sessions;
  //   }

  //   filtre = filtre.toLowerCase();
  //   return sessions.filter(session => {
  //     return session.cours.professeur.nom_Complet.toLowerCase().includes(filtre) ||
  //            session.cours.classe.libelle.toLowerCase().includes(filtre) ||
  //            session.date.toLowerCase().includes(filtre);
  //   });
  // }
  pagePrecedente() {
    if (this.page > 1) {
      this.page--;
    }
  }

  pageSuivante() {
    const totalPages = Math.ceil(this.sessions.length / 5);
    if (this.page < totalPages) {
      this.page++;
    }
  }

  ouvrirModal() {
    this.afficherModal = true;
  }

  fermerModal() {
    // Méthode pour fermer la boîte modale
    this.afficherModal = false;
  }

  // Dans le composant Angular
  // onDateSelected(date: string) {
  //   this.selectedDate = date;
  // }

  onClassSelected(className: string) {
    this.selectedClass = className;
  }

  onMonthSelected(month: string) {
    this.selectedMonth = month;
  }

  onProfessorSelected(professorName: string) {
    this.selectedProfessor = professorName;
  }
  // Dans le composant Angular
  // filterSessions() {
  //   this.filteredSessions = this.sessions.filter((session) => {
  //     return (
  //       (!this.selectedDate || session.date === this.selectedDate) &&
  //       (!this.selectedClass ||
  //         session.cours.classe.libelle === this.selectedClass) &&
  //       (!this.selectedMonth || session.date.includes(this.selectedMonth)) && // Ajoutez la logique pour comparer avec le mois
  //       (!this.selectedProfessor ||
  //         session.cours.professeur.nom_Complet === this.selectedProfessor)
  //     );
  //   });
  // }
  filterSessionsByDate() {
    if (this.selectedDate) {
      this.filteredSessions = this.sessions.filter((session) => {
        return new Date(session.date).toDateString() === this.selectedDate.toDateString();
      });
    } else {
      // Si aucune date n'est sélectionnée, affichez toutes les sessions
      this.filteredSessions = this.sessions;
    }
  }

}
