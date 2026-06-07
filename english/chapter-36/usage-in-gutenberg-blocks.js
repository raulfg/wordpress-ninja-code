// src/portfolio-featured/edit.js
import { useState, useEffect } from '@wordpress/element';
import { executeAbility } from '@wordpress/abilities';
import { Spinner } from '@wordpress/components';

export default function Edit( { attributes } ) {
    const { count } = attributes;
    const [ projects, setProjects ] = useState( [] );
    const [ isLoading, setIsLoading ] = useState( true );

    useEffect( () => {
        setIsLoading( true );

        executeAbility( 'ninja-portfolio/get-projects', {
            featured: true,
            limit: count,
        } )
            .then( setProjects )
            .catch( () => setProjects( [] ) )
            .finally( () => setIsLoading( false ) );
    }, [ count ] );

    if ( isLoading ) {
        return <Spinner />;
    }

    return (
        <div className="ninja-featured-projects">
            { projects.map( ( project ) => (
                <article key={ project.id }>
                    <h3>{ project.title }</h3>
                    { project.client && <p>{ project.client }</p> }
                </article>
            ) ) }
        </div>
    );
}
