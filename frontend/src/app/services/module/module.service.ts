import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ModuleService {

  constructor(protected http: HttpClient) {}

     createModule(module: any): Observable<any> {
       return this.http.post<any>(`${environment.baseUrl}modules`, module);
     }

     updateModule(moduleId: any, module: any): Observable<any> {
       return this.http.put<any>(`${environment.baseUrl}modules/${moduleId}`, module);
     }
  
     getModuleById(moduleId: any): Observable<any> {
       return this.http.get<any>(`${environment.baseUrl}modules/${moduleId}`);
     }

   getAllModules(req?: any): Observable<any> {
    let params: HttpParams = new HttpParams();
  
    if (req) {
      if (req.titre) {
        params = params.append("titre", req.titre);
      }
      if (req.ordre) {
        params = params.append("ordre", req.ordre);
      }
      if(req?.formation != undefined && req?.formation){
        params = params.append("formation", req?.formation);
      }
       if (req.formationId) {
      params = params.append("formationId", req.formationId);
    }
            
      params = params.append("page", req.page ?? 0);
      params = params.append("size", req.size ?? 10);
    } else {
      params = params.append("page", 0);
      params = params.append("size", 100000);
    }

    return this.http.get<any>(`${environment.baseUrl}modules/all`, { params });
  }


     deleteModule(moduleId: any): Observable<any> {
       return this.http.delete<any>(`${environment.baseUrl}modules/${moduleId}`, {
         observe: 'response'
       });
     }
}
