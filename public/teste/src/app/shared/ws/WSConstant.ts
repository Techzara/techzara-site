import {environment} from '../../../environments/environment';

export const WSConstant = Object.freeze({
  LOGIN: environment.wsBasePath + '/login',
  LOGOUT: environment.wsBasePath + '/login',
  RENEW_PASSWORD: environment.wsBasePath + '/login'
});
