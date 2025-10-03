import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(private http: HttpClient) {}

  getUsers(): Observable<any> {
    return this.http.get<any>(`${environment.baseUrl}users`);
  }

  getUserById(userId : any): Observable<any> {
    return this.http.get<any>(`${environment.baseUrl}user/${userId}`);
  }

  deleteUser(userId : any): Observable<any> {
    return this.http.delete<any>(`${environment.baseUrl}user/${userId}`);
  }

  updateUser(userId: any, user: any): Observable<any> {
    return this.http.put<any>(`${environment.baseUrl}user/${userId}`, user);
  }
}
