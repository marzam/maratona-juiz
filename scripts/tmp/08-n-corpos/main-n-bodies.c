#include <stdio.h>
#include <stdlib.h>
#include <assert.h>
#include <time.h>
#include <math.h>
#include <string.h>
#define EPSILON 1E-9
/*Declarando as structs de particula e forca*/
void printLog(double *px, double *py, double *pz,
              double *vx, double *vy, double *vz,
              double *fx, double *fy, double *fz, int nParticles, int timestep){
    
    
    
    FILE *ptr = fopen("solucao.bin", "w+");
    fwrite (px, sizeof(double),nParticles, ptr);
    fwrite (py, sizeof(double),nParticles, ptr);
    fwrite (pz, sizeof(double),nParticles, ptr);
    
    fclose(ptr);
    fprintf(stdout, "[OK]\n"); fflush(stdout);
}
void initialCondition(double *px, double *py, double *pz,
                      double *vx, double *vy, double *vz,
                      double *fx, double *fy, double *fz, int nParticles){

    srand(42);
    memset(vx, 0x00, nParticles * sizeof(double));
    memset(vy, 0x00, nParticles * sizeof(double));
    memset(vz, 0x00, nParticles * sizeof(double));

    memset(fx, 0x00, nParticles * sizeof(double));
    memset(fy, 0x00, nParticles * sizeof(double));
    memset(fz, 0x00, nParticles * sizeof(double));

    for (int i = 0; i < nParticles ; i++){
        px[i] =  2.0 * (rand() / (double)RAND_MAX) - 1.0;
        py[i] =  2.0 * (rand() / (double)RAND_MAX) - 1.0;
        pz[i] =  2.0 * (rand() / (double)RAND_MAX) - 1.0;
    }//end-for (int i = 0; i < nParticles ; i++){

}

double distance(double *dx,
               double *dy,
               double *dz,
               const double A_px,
               const double A_py,
               const double A_pz,
               const double B_px,
               const double B_py,
               const double B_pz){
    double x = A_px - B_px;
    double y = A_py - B_py;
    double z = A_pz - B_pz;
    *dx = x;
    *dy = y;
    *dz = z;
    double d = (x * x) + (y * y) + (z * z) + EPSILON;
    d = 1.0/d;
    return (d * d);

}



void particleParticle (double *px, double *py, double *pz,
                       double *vx, double *vy, double *vz,
                       double *fx, double *fy, double *fz,
                       int nParticles, int timesteps, double dt){

    for (int t = 0; t < timesteps; t++){
        //---------------------------------------------------
            for(int i = 0; i < nParticles; i++){
                for(int j = 0; j < nParticles; j++){
                    double dx = 0.0f;
                    double dy = 0.0f;
                    double dz = 0.0f;
                    double d  = distance(&dx, &dy, &dz, px[i], py[i], pz[i],
                                                       px[j], py[j], pz[j]);
                    fx[i] += dx * d;
                    fy[i] += dy * d;
                    fz[i] += dz * d;
                }
            }
        ////---------------------------------------------------
            for(int i = 0; i < nParticles; i++){
              vx[i] += dt * fx[i];
              vy[i] += dt * fy[i];
              vz[i] += dt * fz[i];

              px[i] += vx[i] * dt;
              py[i] += vy[i] * dt;
              pz[i] += vz[i] * dt;

            }
    }//end-for (int t = 0; t < timesteps; t++){

}//end-void particleParticle



int main (int ac, char **av){
    int timesteps  = atoi(av[1]),
        nParticles = atoi(av[2]),
   	    flagSave = atoi(av[3]);

    double      dt =  0.01f,
               *px = NULL,
               *py = NULL,
               *pz = NULL,
               *vx = NULL,
               *vy = NULL,
               *vz = NULL,
               *fx = NULL,
               *fy = NULL,
               *fz = NULL;
    char logFile[1024];
	fprintf(stdout, "\nP2P particle system \n");
    fprintf(stdout, "\nParcile system particle to particle \n");
    fprintf(stdout, "Memory used %lu bytes \n", nParticles * sizeof(double) * 9);
    fprintf(stdout, "File %s \n", logFile);

    px = (double *) malloc(nParticles * sizeof(double));
    assert(px != NULL);
    py = (double *) malloc(nParticles * sizeof(double));
    assert(py != NULL);
    pz = (double *) malloc(nParticles * sizeof(double));
    assert(pz != NULL);
//-------------------------
    vx = (double *) malloc(nParticles * sizeof(double));
    assert(vx != NULL);
    vy = (double *) malloc(nParticles * sizeof(double));
    assert(vy != NULL);
    vz = (double *) malloc(nParticles * sizeof(double));
    assert(vz != NULL);

//-------------------------
    fx = (double *) malloc(nParticles * sizeof(double));
    assert(fx != NULL);
    fy = (double *) malloc(nParticles * sizeof(double));
    assert(fy != NULL);
    fz = (double *)malloc(nParticles * sizeof(double));
    assert(fz != NULL);
//-------------------------

    initialCondition(px, py, pz,
                     vx, vy, vz,
                     fx, fy, fz, nParticles);


    particleParticle(px, py, pz, vx, vy, vz, fx, fy, fz, nParticles, timesteps, dt);


    if (flagSave == 1)
       printLog(px, py, pz, vx, vy, vz, fx, fy, fz,  nParticles, timesteps);


    free(px);free(py); free(pz);
    free(vx);free(vy); free(vz);
    free(fx);free(fy); free(fz);

}
