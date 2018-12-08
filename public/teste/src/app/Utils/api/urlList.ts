import {environment} from '../../../environments/environment';

const _api = environment.base_url_api + '/';

export const urlList = {
  path_login: _api + 'users/login',
  path_list_class: _api + 'class/find',
  path_edit_class: _api + 'class/edit',
  path_list_salle: _api + 'salle/find',
  path_edit_salle: _api + 'salle/edit',
  path_teste_user: _api + 'users'
};
