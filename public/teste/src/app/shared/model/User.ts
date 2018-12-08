export class User {

  constructor(
    public name: string,
    public matricule: string,
    public hash: string,
    public token?: string
  ) {  }
}
