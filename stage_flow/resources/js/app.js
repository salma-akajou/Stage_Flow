import './bootstrap';

import publicLayout from './components/public/publicLayout';
import navbarPublic from './components/public/navbarPublic';

import dropdownFilter     from './components/etudiant/dropdownFilter';
import offresCatalog      from './components/etudiant/offresCatalog';
import customSelect       from './components/etudiant/customSelect';
import selectVille        from './components/etudiant/selectVille';
import photoUpload        from './components/etudiant/photoUpload';
import fileUpload         from './components/etudiant/fileUpload';
import starRating         from './components/etudiant/starRating';
import candidaturesFilter from './components/etudiant/candidaturesFilter';
import './components/etudiant/offresShow';

import './components/entreprise/entrepriseModals';
import candidatureManager from './components/entreprise/candidaturesIndex';
import offreManager from './components/entreprise/offresIndex';
import logoUpload from './components/entreprise/logoUpload';

import './components/admin/adminCommon';
import usersFilter from './components/admin/usersFilter';
import feedbacksFilter from './components/admin/feedbacksFilter';
import adminChart from './components/admin/adminChart';

document.addEventListener('alpine:init', () => {
    Alpine.data('publicLayout',       publicLayout);
    Alpine.data('navbarPublic',       navbarPublic);
    Alpine.data('dropdownFilter',     dropdownFilter);
    Alpine.data('offresCatalog',      offresCatalog);
    Alpine.data('customSelect',       customSelect);
    Alpine.data('selectVille',        selectVille);
    Alpine.data('photoUpload',        photoUpload);
    Alpine.data('fileUpload',         fileUpload);
    Alpine.data('starRating',         starRating);
    Alpine.data('candidaturesFilter', candidaturesFilter);

    Alpine.data('candidatureManager', candidatureManager);
    Alpine.data('offreManager',       offreManager);
    Alpine.data('logoUpload',         logoUpload);

    Alpine.data('usersFilter',        usersFilter);
    Alpine.data('feedbacksFilter',    feedbacksFilter);
    Alpine.data('adminChart',         adminChart);
});
