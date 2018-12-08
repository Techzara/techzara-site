import {WsReturnCode} from '../enum/ws-return-code.enum';

export class JsonResponse {
  code: WsReturnCode;
  message: string;
  datas: any;
  show: boolean;
  count?: number;
  pages?: {
    current: number;
    count: number;
  };

  constructor(code: WsReturnCode, message: string) {
    this.code = code;
    this.message = message;
  }
}

export class AuthenticationJsonResponse extends JsonResponse {
  userToken;
}
