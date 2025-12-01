--
-- PostgreSQL database dump
--

\restrict G8Vs48tWb9Dk9v2SZIaIxPY7NKZ2m5wscEJfYuqtKthMlu3c2PYDGhkncvmZ33a

-- Dumped from database version 16.10 (0374078)
-- Dumped by pg_dump version 16.10

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: public; Type: SCHEMA; Schema: -; Owner: neondb_owner
--

-- *not* creating schema, since initdb creates it


ALTER SCHEMA public OWNER TO neondb_owner;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: neondb_owner
--

COMMENT ON SCHEMA public IS '';


--
-- Name: update_admissions_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_admissions_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_admissions_updated_at() OWNER TO neondb_owner;

--
-- Name: update_announcements_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_announcements_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_announcements_updated_at() OWNER TO neondb_owner;

--
-- Name: update_assets_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_assets_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_assets_updated_at() OWNER TO neondb_owner;

--
-- Name: update_assignments_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_assignments_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_assignments_updated_at() OWNER TO neondb_owner;

--
-- Name: update_attendance_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_attendance_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_attendance_updated_at() OWNER TO neondb_owner;

--
-- Name: update_books_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_books_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_books_updated_at() OWNER TO neondb_owner;

--
-- Name: update_classes_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_classes_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_classes_updated_at() OWNER TO neondb_owner;

--
-- Name: update_courses_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_courses_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_courses_updated_at() OWNER TO neondb_owner;

--
-- Name: update_departments_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_departments_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_departments_updated_at() OWNER TO neondb_owner;

--
-- Name: update_exams_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_exams_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_exams_updated_at() OWNER TO neondb_owner;

--
-- Name: update_fee_structure_templates_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_fee_structure_templates_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_fee_structure_templates_updated_at() OWNER TO neondb_owner;

--
-- Name: update_fees_structures_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_fees_structures_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_fees_structures_updated_at() OWNER TO neondb_owner;

--
-- Name: update_hostels_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_hostels_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_hostels_updated_at() OWNER TO neondb_owner;

--
-- Name: update_invoices_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_invoices_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_invoices_updated_at() OWNER TO neondb_owner;

--
-- Name: update_leave_types_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_leave_types_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_leave_types_updated_at() OWNER TO neondb_owner;

--
-- Name: update_marks_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_marks_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_marks_updated_at() OWNER TO neondb_owner;

--
-- Name: update_materials_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_materials_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_materials_updated_at() OWNER TO neondb_owner;

--
-- Name: update_notifications_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_notifications_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_notifications_updated_at() OWNER TO neondb_owner;

--
-- Name: update_roles_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_roles_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_roles_updated_at() OWNER TO neondb_owner;

--
-- Name: update_staff_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_staff_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_staff_updated_at() OWNER TO neondb_owner;

--
-- Name: update_students_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_students_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_students_updated_at() OWNER TO neondb_owner;

--
-- Name: update_subjects_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_subjects_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_subjects_updated_at() OWNER TO neondb_owner;

--
-- Name: update_syllabuses_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_syllabuses_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_syllabuses_updated_at() OWNER TO neondb_owner;

--
-- Name: update_system_settings_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_system_settings_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_system_settings_updated_at() OWNER TO neondb_owner;

--
-- Name: update_timetables_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_timetables_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_timetables_updated_at() OWNER TO neondb_owner;

--
-- Name: update_user_roles_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_user_roles_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_user_roles_updated_at() OWNER TO neondb_owner;

--
-- Name: update_users_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_users_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_users_updated_at() OWNER TO neondb_owner;

--
-- Name: update_vehicles_updated_at(); Type: FUNCTION; Schema: public; Owner: neondb_owner
--

CREATE FUNCTION public.update_vehicles_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.update_vehicles_updated_at() OWNER TO neondb_owner;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: academic_calendar; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.academic_calendar (
    id integer NOT NULL,
    academic_year character varying(50) NOT NULL,
    start_date date NOT NULL,
    end_date date NOT NULL,
    session_name character varying(255),
    session_start date,
    session_end date,
    exam_start date,
    exam_end date,
    admission_start date,
    admission_end date,
    holidays text,
    important_events text,
    status character varying(50) DEFAULT 'active'::character varying,
    notes text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone
);


ALTER TABLE public.academic_calendar OWNER TO neondb_owner;

--
-- Name: academic_calendar_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.academic_calendar_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.academic_calendar_id_seq OWNER TO neondb_owner;

--
-- Name: academic_calendar_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.academic_calendar_id_seq OWNED BY public.academic_calendar.id;


--
-- Name: admissions; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.admissions (
    id integer NOT NULL,
    application_number character varying(50) NOT NULL,
    first_name character varying(50) NOT NULL,
    last_name character varying(50) NOT NULL,
    email character varying(100) NOT NULL,
    phone character varying(20) NOT NULL,
    date_of_birth date NOT NULL,
    gender character varying(50) NOT NULL,
    address text NOT NULL,
    course_id integer,
    class_id integer,
    guardian_name character varying(100) NOT NULL,
    guardian_phone character varying(20) NOT NULL,
    guardian_email character varying(100),
    previous_school character varying(200),
    documents json,
    status character varying(50) DEFAULT 'pending'::character varying,
    remarks text,
    reviewed_by integer,
    reviewed_at timestamp without time zone,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT admissions_gender_check CHECK (((gender)::text = ANY ((ARRAY['male'::character varying, 'female'::character varying, 'other'::character varying])::text[]))),
    CONSTRAINT admissions_status_check CHECK (((status)::text = ANY (ARRAY[('pending'::character varying)::text, ('approved'::character varying)::text, ('rejected'::character varying)::text, ('waitlisted'::character varying)::text, ('completed'::character varying)::text])))
);


ALTER TABLE public.admissions OWNER TO neondb_owner;

--
-- Name: admissions_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.admissions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.admissions_id_seq OWNER TO neondb_owner;

--
-- Name: admissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.admissions_id_seq OWNED BY public.admissions.id;


--
-- Name: announcements; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.announcements (
    id integer NOT NULL,
    title character varying(255) NOT NULL,
    content text NOT NULL,
    target_audience character varying(50),
    priority character varying(20) DEFAULT 'normal'::character varying,
    published_by integer NOT NULL,
    published_date timestamp without time zone NOT NULL,
    expiry_date timestamp without time zone,
    attachment_path character varying(255),
    is_visible boolean DEFAULT true,
    views_count integer DEFAULT 0,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.announcements OWNER TO neondb_owner;

--
-- Name: announcements_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.announcements_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.announcements_id_seq OWNER TO neondb_owner;

--
-- Name: announcements_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.announcements_id_seq OWNED BY public.announcements.id;


--
-- Name: assets; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.assets (
    id integer NOT NULL,
    asset_code character varying(50) NOT NULL,
    name character varying(255) NOT NULL,
    category character varying(100),
    description text,
    purchase_date date,
    purchase_cost numeric(15,2),
    current_value numeric(15,2),
    depreciation_rate numeric(8,2),
    location character varying(255),
    assigned_to integer,
    condition character varying(50) DEFAULT 'good'::character varying,
    warranty_expiry date,
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.assets OWNER TO neondb_owner;

--
-- Name: assets_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.assets_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.assets_id_seq OWNER TO neondb_owner;

--
-- Name: assets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.assets_id_seq OWNED BY public.assets.id;


--
-- Name: assignment_submissions; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.assignment_submissions (
    id integer NOT NULL,
    assignment_id integer NOT NULL,
    student_id integer NOT NULL,
    submission_date timestamp without time zone NOT NULL,
    submission_text text,
    attachment_path character varying(255),
    marks_obtained integer,
    feedback text,
    graded_by integer,
    graded_date date,
    status character varying(20) DEFAULT 'submitted'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.assignment_submissions OWNER TO neondb_owner;

--
-- Name: assignment_submissions_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.assignment_submissions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.assignment_submissions_id_seq OWNER TO neondb_owner;

--
-- Name: assignment_submissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.assignment_submissions_id_seq OWNED BY public.assignment_submissions.id;


--
-- Name: assignments; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.assignments (
    id integer NOT NULL,
    title character varying(255) NOT NULL,
    subject_id integer NOT NULL,
    class_id integer NOT NULL,
    teacher_id integer NOT NULL,
    description text,
    instructions text,
    attachment_path character varying(255),
    assigned_date date NOT NULL,
    due_date date NOT NULL,
    total_marks integer DEFAULT 100,
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.assignments OWNER TO neondb_owner;

--
-- Name: assignments_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.assignments_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.assignments_id_seq OWNER TO neondb_owner;

--
-- Name: assignments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.assignments_id_seq OWNED BY public.assignments.id;


--
-- Name: attendance; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.attendance (
    id integer NOT NULL,
    student_id integer NOT NULL,
    class_id integer NOT NULL,
    subject_id integer,
    date date NOT NULL,
    period integer,
    status character varying(50) NOT NULL,
    remarks text,
    marked_by integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT attendance_status_check CHECK (((status)::text = ANY ((ARRAY['present'::character varying, 'absent'::character varying, 'late'::character varying, 'excused'::character varying])::text[])))
);


ALTER TABLE public.attendance OWNER TO neondb_owner;

--
-- Name: attendance_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.attendance_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.attendance_id_seq OWNER TO neondb_owner;

--
-- Name: attendance_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.attendance_id_seq OWNED BY public.attendance.id;


--
-- Name: audit_logs; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.audit_logs (
    id integer NOT NULL,
    user_id integer,
    action character varying(100) NOT NULL,
    table_name character varying(100),
    record_id integer,
    old_values text,
    new_values text,
    ip_address character varying(50),
    user_agent text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.audit_logs OWNER TO neondb_owner;

--
-- Name: audit_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.audit_logs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.audit_logs_id_seq OWNER TO neondb_owner;

--
-- Name: audit_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.audit_logs_id_seq OWNED BY public.audit_logs.id;


--
-- Name: book_issues; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.book_issues (
    id integer NOT NULL,
    book_id integer NOT NULL,
    user_id integer NOT NULL,
    issue_date date NOT NULL,
    due_date date NOT NULL,
    return_date date,
    status character varying(20) DEFAULT 'issued'::character varying,
    fine_amount numeric(10,2) DEFAULT 0,
    fine_paid boolean DEFAULT false,
    remarks text,
    issued_by integer,
    returned_to integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.book_issues OWNER TO neondb_owner;

--
-- Name: book_issues_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.book_issues_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.book_issues_id_seq OWNER TO neondb_owner;

--
-- Name: book_issues_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.book_issues_id_seq OWNED BY public.book_issues.id;


--
-- Name: books; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.books (
    id integer NOT NULL,
    isbn character varying(20),
    title character varying(255) NOT NULL,
    author character varying(255) NOT NULL,
    publisher character varying(255),
    publication_year integer,
    category character varying(100),
    total_copies integer DEFAULT 1,
    available_copies integer DEFAULT 1,
    location character varying(100),
    price numeric(10,2),
    description text,
    cover_image character varying(255),
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.books OWNER TO neondb_owner;

--
-- Name: books_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.books_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.books_id_seq OWNER TO neondb_owner;

--
-- Name: books_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.books_id_seq OWNED BY public.books.id;


--
-- Name: budget; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.budget (
    id integer NOT NULL,
    budget_number character varying(50) NOT NULL,
    category character varying(100) NOT NULL,
    description text,
    allocated_amount numeric(12,2) NOT NULL,
    spent_amount numeric(12,2) DEFAULT 0,
    academic_year character varying(20) NOT NULL,
    period character varying(50),
    status character varying(20) DEFAULT 'active'::character varying,
    created_by integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.budget OWNER TO neondb_owner;

--
-- Name: budget_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.budget_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.budget_id_seq OWNER TO neondb_owner;

--
-- Name: budget_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.budget_id_seq OWNED BY public.budget.id;


--
-- Name: budgets; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.budgets (
    id integer NOT NULL,
    budget_name character varying(255) NOT NULL,
    category character varying(100) NOT NULL,
    fiscal_year character varying(20) NOT NULL,
    allocated_amount numeric(10,2) NOT NULL,
    spent_amount numeric(10,2) DEFAULT 0,
    remaining_amount numeric(10,2),
    department character varying(100),
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.budgets OWNER TO neondb_owner;

--
-- Name: budgets_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.budgets_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.budgets_id_seq OWNER TO neondb_owner;

--
-- Name: budgets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.budgets_id_seq OWNED BY public.budgets.id;


--
-- Name: calendar_events; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.calendar_events (
    id integer NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    event_date date NOT NULL,
    start_time time without time zone,
    end_time time without time zone,
    location character varying(255),
    event_type character varying(50),
    created_by integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.calendar_events OWNER TO neondb_owner;

--
-- Name: calendar_events_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.calendar_events_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.calendar_events_id_seq OWNER TO neondb_owner;

--
-- Name: calendar_events_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.calendar_events_id_seq OWNED BY public.calendar_events.id;


--
-- Name: classes; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.classes (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    code character varying(20) NOT NULL,
    course_id integer,
    section character varying(10),
    academic_year character varying(20) NOT NULL,
    capacity integer,
    room_number character varying(20),
    status character varying(50) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT classes_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.classes OWNER TO neondb_owner;

--
-- Name: classes_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.classes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.classes_id_seq OWNER TO neondb_owner;

--
-- Name: classes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.classes_id_seq OWNED BY public.classes.id;


--
-- Name: courses; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.courses (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    code character varying(20) NOT NULL,
    description text,
    duration_years integer DEFAULT 3 NOT NULL,
    status character varying(50) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT courses_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.courses OWNER TO neondb_owner;

--
-- Name: courses_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.courses_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.courses_id_seq OWNER TO neondb_owner;

--
-- Name: courses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.courses_id_seq OWNED BY public.courses.id;


--
-- Name: database_backups; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.database_backups (
    id integer NOT NULL,
    backup_name character varying(255) NOT NULL,
    backup_path character varying(255) NOT NULL,
    backup_size bigint,
    backup_type character varying(50),
    created_by integer,
    status character varying(20) DEFAULT 'completed'::character varying,
    error_message text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.database_backups OWNER TO neondb_owner;

--
-- Name: database_backups_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.database_backups_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.database_backups_id_seq OWNER TO neondb_owner;

--
-- Name: database_backups_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.database_backups_id_seq OWNED BY public.database_backups.id;


--
-- Name: departments; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.departments (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    code character varying(50) NOT NULL,
    description text,
    head_id integer,
    parent_department_id integer,
    email character varying(255),
    phone character varying(20),
    location character varying(255),
    budget numeric(10,2),
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.departments OWNER TO neondb_owner;

--
-- Name: departments_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.departments_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.departments_id_seq OWNER TO neondb_owner;

--
-- Name: departments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.departments_id_seq OWNED BY public.departments.id;


--
-- Name: email_logs; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.email_logs (
    id integer NOT NULL,
    recipient_email character varying(255) NOT NULL,
    recipient_name character varying(255),
    subject character varying(255) NOT NULL,
    email_body text NOT NULL,
    sent_by integer,
    sent_at timestamp without time zone NOT NULL,
    status character varying(20) DEFAULT 'sent'::character varying,
    error_message text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.email_logs OWNER TO neondb_owner;

--
-- Name: email_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.email_logs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.email_logs_id_seq OWNER TO neondb_owner;

--
-- Name: email_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.email_logs_id_seq OWNED BY public.email_logs.id;


--
-- Name: exams; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.exams (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    code character varying(20) NOT NULL,
    class_id integer,
    exam_type character varying(50) NOT NULL,
    academic_year character varying(20) NOT NULL,
    semester character varying(20),
    start_date date NOT NULL,
    end_date date NOT NULL,
    total_marks integer DEFAULT 100 NOT NULL,
    passing_marks integer DEFAULT 40 NOT NULL,
    status character varying(50) DEFAULT 'scheduled'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT exams_exam_type_check CHECK (((exam_type)::text = ANY ((ARRAY['midterm'::character varying, 'final'::character varying, 'quiz'::character varying, 'assignment'::character varying, 'practical'::character varying])::text[]))),
    CONSTRAINT exams_status_check CHECK (((status)::text = ANY ((ARRAY['scheduled'::character varying, 'ongoing'::character varying, 'completed'::character varying, 'cancelled'::character varying])::text[])))
);


ALTER TABLE public.exams OWNER TO neondb_owner;

--
-- Name: exams_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.exams_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.exams_id_seq OWNER TO neondb_owner;

--
-- Name: exams_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.exams_id_seq OWNED BY public.exams.id;


--
-- Name: expenses; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.expenses (
    id integer NOT NULL,
    expense_number character varying(50) NOT NULL,
    category character varying(100) NOT NULL,
    description text,
    amount numeric(10,2) NOT NULL,
    expense_date date NOT NULL,
    payment_method character varying(50),
    vendor character varying(255),
    invoice_number character varying(100),
    approved_by integer,
    status character varying(20) DEFAULT 'pending'::character varying,
    created_by integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.expenses OWNER TO neondb_owner;

--
-- Name: expenses_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.expenses_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.expenses_id_seq OWNER TO neondb_owner;

--
-- Name: expenses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.expenses_id_seq OWNED BY public.expenses.id;


--
-- Name: fee_structure_templates; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.fee_structure_templates (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    class_id integer,
    academic_year character varying(20),
    amount numeric(10,2) NOT NULL,
    due_date date,
    fine_per_day numeric(10,2) DEFAULT 0,
    description text,
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.fee_structure_templates OWNER TO neondb_owner;

--
-- Name: fee_structure_templates_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.fee_structure_templates_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.fee_structure_templates_id_seq OWNER TO neondb_owner;

--
-- Name: fee_structure_templates_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.fee_structure_templates_id_seq OWNED BY public.fee_structure_templates.id;


--
-- Name: fees_structures; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.fees_structures (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    class_id integer,
    course_id integer,
    academic_year character varying(20) NOT NULL,
    semester character varying(20),
    fee_type character varying(50) NOT NULL,
    amount numeric(10,2) NOT NULL,
    due_date date,
    status character varying(50) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fees_structures_fee_type_check CHECK (((fee_type)::text = ANY ((ARRAY['tuition'::character varying, 'exam'::character varying, 'library'::character varying, 'lab'::character varying, 'transport'::character varying, 'hostel'::character varying, 'other'::character varying])::text[]))),
    CONSTRAINT fees_structures_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.fees_structures OWNER TO neondb_owner;

--
-- Name: fees_structures_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.fees_structures_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.fees_structures_id_seq OWNER TO neondb_owner;

--
-- Name: fees_structures_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.fees_structures_id_seq OWNED BY public.fees_structures.id;


--
-- Name: forum_posts; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.forum_posts (
    id integer NOT NULL,
    forum_id integer NOT NULL,
    parent_post_id integer,
    user_id integer NOT NULL,
    post_content text NOT NULL,
    attachment_path character varying(255),
    likes_count integer DEFAULT 0,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.forum_posts OWNER TO neondb_owner;

--
-- Name: forum_posts_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.forum_posts_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.forum_posts_id_seq OWNER TO neondb_owner;

--
-- Name: forum_posts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.forum_posts_id_seq OWNED BY public.forum_posts.id;


--
-- Name: forums; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.forums (
    id integer NOT NULL,
    title character varying(255) NOT NULL,
    subject_id integer,
    class_id integer,
    description text,
    created_by integer NOT NULL,
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.forums OWNER TO neondb_owner;

--
-- Name: forums_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.forums_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.forums_id_seq OWNER TO neondb_owner;

--
-- Name: forums_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.forums_id_seq OWNED BY public.forums.id;


--
-- Name: holidays; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.holidays (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    description text,
    start_date date NOT NULL,
    end_date date NOT NULL,
    holiday_type character varying(50),
    status character varying(20) DEFAULT 'active'::character varying,
    created_by integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.holidays OWNER TO neondb_owner;

--
-- Name: holidays_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.holidays_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.holidays_id_seq OWNER TO neondb_owner;

--
-- Name: holidays_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.holidays_id_seq OWNED BY public.holidays.id;


--
-- Name: hostel_complaints; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.hostel_complaints (
    id integer NOT NULL,
    resident_id integer NOT NULL,
    hostel_id integer NOT NULL,
    complaint_type character varying(100),
    description text NOT NULL,
    priority character varying(20) DEFAULT 'medium'::character varying,
    status character varying(20) DEFAULT 'pending'::character varying,
    assigned_to integer,
    resolved_date date,
    remarks text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.hostel_complaints OWNER TO neondb_owner;

--
-- Name: hostel_complaints_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.hostel_complaints_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.hostel_complaints_id_seq OWNER TO neondb_owner;

--
-- Name: hostel_complaints_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.hostel_complaints_id_seq OWNED BY public.hostel_complaints.id;


--
-- Name: hostel_residents; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.hostel_residents (
    id integer NOT NULL,
    student_id integer NOT NULL,
    hostel_id integer NOT NULL,
    room_id integer NOT NULL,
    admission_date date NOT NULL,
    checkout_date date,
    guardian_contact character varying(20),
    emergency_contact character varying(20),
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.hostel_residents OWNER TO neondb_owner;

--
-- Name: hostel_residents_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.hostel_residents_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.hostel_residents_id_seq OWNER TO neondb_owner;

--
-- Name: hostel_residents_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.hostel_residents_id_seq OWNED BY public.hostel_residents.id;


--
-- Name: hostel_rooms; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.hostel_rooms (
    id integer NOT NULL,
    hostel_id integer NOT NULL,
    room_number character varying(50) NOT NULL,
    room_type character varying(50),
    capacity integer DEFAULT 1,
    occupied_beds integer DEFAULT 0,
    floor_number integer,
    room_fee numeric(10,2),
    amenities text,
    status character varying(20) DEFAULT 'available'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.hostel_rooms OWNER TO neondb_owner;

--
-- Name: hostel_rooms_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.hostel_rooms_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.hostel_rooms_id_seq OWNER TO neondb_owner;

--
-- Name: hostel_rooms_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.hostel_rooms_id_seq OWNED BY public.hostel_rooms.id;


--
-- Name: hostel_visitors; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.hostel_visitors (
    id integer NOT NULL,
    resident_id integer NOT NULL,
    visitor_name character varying(255) NOT NULL,
    visitor_phone character varying(20),
    visitor_id_proof character varying(100),
    visit_date date NOT NULL,
    entry_time time without time zone NOT NULL,
    exit_time time without time zone,
    purpose text,
    approved_by integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.hostel_visitors OWNER TO neondb_owner;

--
-- Name: hostel_visitors_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.hostel_visitors_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.hostel_visitors_id_seq OWNER TO neondb_owner;

--
-- Name: hostel_visitors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.hostel_visitors_id_seq OWNED BY public.hostel_visitors.id;


--
-- Name: hostels; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.hostels (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    hostel_type character varying(50),
    address text,
    warden_id integer,
    total_rooms integer DEFAULT 0,
    occupied_rooms integer DEFAULT 0,
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.hostels OWNER TO neondb_owner;

--
-- Name: hostels_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.hostels_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.hostels_id_seq OWNER TO neondb_owner;

--
-- Name: hostels_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.hostels_id_seq OWNED BY public.hostels.id;


--
-- Name: hr_events; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.hr_events (
    id integer NOT NULL,
    title character varying(255) NOT NULL,
    description text,
    event_date date NOT NULL,
    event_type character varying(50),
    location character varying(255),
    created_by integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.hr_events OWNER TO neondb_owner;

--
-- Name: hr_events_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.hr_events_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.hr_events_id_seq OWNER TO neondb_owner;

--
-- Name: hr_events_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.hr_events_id_seq OWNED BY public.hr_events.id;


--
-- Name: integrations; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.integrations (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    integration_type character varying(50),
    api_key text,
    api_secret text,
    endpoint_url character varying(255),
    configuration text,
    is_active boolean DEFAULT false,
    last_sync timestamp without time zone,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.integrations OWNER TO neondb_owner;

--
-- Name: integrations_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.integrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.integrations_id_seq OWNER TO neondb_owner;

--
-- Name: integrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.integrations_id_seq OWNED BY public.integrations.id;


--
-- Name: inventory_items; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.inventory_items (
    id integer NOT NULL,
    item_code character varying(50) NOT NULL,
    name character varying(255) NOT NULL,
    category character varying(100),
    description text,
    unit character varying(50),
    quantity integer DEFAULT 0,
    reorder_level integer DEFAULT 10,
    unit_price numeric(10,2),
    location character varying(255),
    status character varying(20) DEFAULT 'in_stock'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.inventory_items OWNER TO neondb_owner;

--
-- Name: inventory_items_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.inventory_items_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.inventory_items_id_seq OWNER TO neondb_owner;

--
-- Name: inventory_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.inventory_items_id_seq OWNED BY public.inventory_items.id;


--
-- Name: invoices; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.invoices (
    id integer NOT NULL,
    invoice_number character varying(50) NOT NULL,
    student_id integer NOT NULL,
    fee_structure_id integer,
    amount numeric(10,2) NOT NULL,
    discount numeric(10,2) DEFAULT 0.00,
    tax numeric(10,2) DEFAULT 0.00,
    total_amount numeric(10,2) NOT NULL,
    amount_paid numeric(10,2) DEFAULT 0.00,
    balance numeric(10,2) NOT NULL,
    due_date date,
    payment_status character varying(50) DEFAULT 'unpaid'::character varying,
    payment_method character varying(50),
    transaction_id character varying(100),
    payment_date date,
    remarks text,
    created_by integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT invoices_payment_status_check CHECK (((payment_status)::text = ANY ((ARRAY['unpaid'::character varying, 'partial'::character varying, 'paid'::character varying, 'overdue'::character varying])::text[])))
);


ALTER TABLE public.invoices OWNER TO neondb_owner;

--
-- Name: invoices_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.invoices_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.invoices_id_seq OWNER TO neondb_owner;

--
-- Name: invoices_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.invoices_id_seq OWNED BY public.invoices.id;


--
-- Name: leave_applications; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.leave_applications (
    id integer NOT NULL,
    application_number character varying(50) NOT NULL,
    user_id integer NOT NULL,
    leave_type_id integer NOT NULL,
    start_date date NOT NULL,
    end_date date NOT NULL,
    total_days integer NOT NULL,
    reason text NOT NULL,
    status character varying(20) DEFAULT 'pending'::character varying,
    applied_date date NOT NULL,
    reviewed_by integer,
    reviewed_date date,
    remarks text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.leave_applications OWNER TO neondb_owner;

--
-- Name: leave_applications_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.leave_applications_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.leave_applications_id_seq OWNER TO neondb_owner;

--
-- Name: leave_applications_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.leave_applications_id_seq OWNED BY public.leave_applications.id;


--
-- Name: leave_balances; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.leave_balances (
    id integer NOT NULL,
    user_id integer NOT NULL,
    leave_type_id integer NOT NULL,
    year integer NOT NULL,
    total_days integer DEFAULT 0,
    used_days integer DEFAULT 0,
    remaining_days integer DEFAULT 0,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.leave_balances OWNER TO neondb_owner;

--
-- Name: leave_balances_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.leave_balances_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.leave_balances_id_seq OWNER TO neondb_owner;

--
-- Name: leave_balances_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.leave_balances_id_seq OWNED BY public.leave_balances.id;


--
-- Name: leave_types; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.leave_types (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    code character varying(20) NOT NULL,
    days_allowed integer DEFAULT 0,
    applicable_to character varying(50),
    requires_approval boolean DEFAULT true,
    description text,
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.leave_types OWNER TO neondb_owner;

--
-- Name: leave_types_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.leave_types_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.leave_types_id_seq OWNER TO neondb_owner;

--
-- Name: leave_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.leave_types_id_seq OWNED BY public.leave_types.id;


--
-- Name: leaves; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.leaves (
    id integer NOT NULL,
    user_id integer NOT NULL,
    leave_type character varying(50) NOT NULL,
    start_date date NOT NULL,
    end_date date NOT NULL,
    reason text,
    status character varying(20) DEFAULT 'pending'::character varying,
    approved_by integer,
    remarks text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.leaves OWNER TO neondb_owner;

--
-- Name: leaves_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.leaves_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.leaves_id_seq OWNER TO neondb_owner;

--
-- Name: leaves_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.leaves_id_seq OWNED BY public.leaves.id;


--
-- Name: lesson_plans; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.lesson_plans (
    id integer NOT NULL,
    subject_id integer,
    class_id integer,
    topic character varying(255) NOT NULL,
    lesson_date date,
    duration integer,
    period_number integer,
    learning_outcomes text,
    introduction text,
    content text,
    activities text,
    conclusion text,
    assessment_method text,
    resources text,
    homework text,
    remarks text,
    status character varying(50) DEFAULT 'active'::character varying,
    difficulty_level character varying(50),
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone
);


ALTER TABLE public.lesson_plans OWNER TO neondb_owner;

--
-- Name: lesson_plans_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.lesson_plans_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.lesson_plans_id_seq OWNER TO neondb_owner;

--
-- Name: lesson_plans_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.lesson_plans_id_seq OWNED BY public.lesson_plans.id;


--
-- Name: library_members; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.library_members (
    id integer NOT NULL,
    user_id integer NOT NULL,
    member_number character varying(50) NOT NULL,
    membership_type character varying(50) DEFAULT 'standard'::character varying,
    join_date date NOT NULL,
    expiry_date date,
    max_books integer DEFAULT 3,
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.library_members OWNER TO neondb_owner;

--
-- Name: library_members_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.library_members_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.library_members_id_seq OWNER TO neondb_owner;

--
-- Name: library_members_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.library_members_id_seq OWNED BY public.library_members.id;


--
-- Name: marks; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.marks (
    id integer NOT NULL,
    student_id integer NOT NULL,
    exam_id integer NOT NULL,
    subject_id integer NOT NULL,
    marks_obtained numeric(5,2) NOT NULL,
    total_marks numeric(5,2) NOT NULL,
    grade character varying(5),
    remarks text,
    entered_by integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.marks OWNER TO neondb_owner;

--
-- Name: marks_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.marks_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.marks_id_seq OWNER TO neondb_owner;

--
-- Name: marks_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.marks_id_seq OWNED BY public.marks.id;


--
-- Name: materials; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.materials (
    id integer NOT NULL,
    title character varying(200) NOT NULL,
    description text,
    file_path character varying(255) NOT NULL,
    file_type character varying(255),
    file_size integer,
    subject_id integer,
    class_id integer,
    uploaded_by integer NOT NULL,
    downloads integer DEFAULT 0,
    type character varying(50) DEFAULT 'notes'::character varying,
    status character varying(50) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT materials_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[]))),
    CONSTRAINT materials_type_check CHECK (((type)::text = ANY ((ARRAY['notes'::character varying, 'assignment'::character varying, 'syllabus'::character varying, 'question_paper'::character varying, 'other'::character varying])::text[])))
);


ALTER TABLE public.materials OWNER TO neondb_owner;

--
-- Name: materials_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.materials_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.materials_id_seq OWNER TO neondb_owner;

--
-- Name: materials_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.materials_id_seq OWNED BY public.materials.id;


--
-- Name: mess_menu; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.mess_menu (
    id integer NOT NULL,
    hostel_id integer NOT NULL,
    day_of_week character varying(20) NOT NULL,
    meal_type character varying(50) NOT NULL,
    menu_items text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.mess_menu OWNER TO neondb_owner;

--
-- Name: mess_menu_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.mess_menu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.mess_menu_id_seq OWNER TO neondb_owner;

--
-- Name: mess_menu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.mess_menu_id_seq OWNED BY public.mess_menu.id;


--
-- Name: messages; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.messages (
    id integer NOT NULL,
    sender_id integer NOT NULL,
    receiver_id integer NOT NULL,
    subject character varying(255),
    message_body text NOT NULL,
    is_read boolean DEFAULT false,
    read_at timestamp without time zone,
    attachment_path character varying(255),
    parent_message_id integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.messages OWNER TO neondb_owner;

--
-- Name: messages_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.messages_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.messages_id_seq OWNER TO neondb_owner;

--
-- Name: messages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.messages_id_seq OWNED BY public.messages.id;


--
-- Name: notifications; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.notifications (
    id integer NOT NULL,
    user_id integer,
    title character varying(200) NOT NULL,
    message text NOT NULL,
    type character varying(50) DEFAULT 'info'::character varying,
    link character varying(255),
    is_read boolean DEFAULT false,
    read_at timestamp without time zone,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT notifications_type_check CHECK (((type)::text = ANY ((ARRAY['info'::character varying, 'success'::character varying, 'warning'::character varying, 'error'::character varying])::text[])))
);


ALTER TABLE public.notifications OWNER TO neondb_owner;

--
-- Name: notifications_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.notifications_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.notifications_id_seq OWNER TO neondb_owner;

--
-- Name: notifications_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.notifications_id_seq OWNED BY public.notifications.id;


--
-- Name: otp_resets; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.otp_resets (
    id integer NOT NULL,
    email character varying(100) NOT NULL,
    otp character varying(6) NOT NULL,
    expires_at timestamp without time zone NOT NULL,
    is_used boolean DEFAULT false,
    used_at timestamp without time zone,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.otp_resets OWNER TO neondb_owner;

--
-- Name: otp_resets_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.otp_resets_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.otp_resets_id_seq OWNER TO neondb_owner;

--
-- Name: otp_resets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.otp_resets_id_seq OWNED BY public.otp_resets.id;


--
-- Name: payroll; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.payroll (
    id integer NOT NULL,
    payroll_number character varying(50) NOT NULL,
    staff_id integer NOT NULL,
    month character varying(20) NOT NULL,
    year integer NOT NULL,
    basic_salary numeric(10,2) NOT NULL,
    allowances numeric(10,2) DEFAULT 0,
    deductions numeric(10,2) DEFAULT 0,
    gross_salary numeric(10,2) NOT NULL,
    net_salary numeric(10,2) NOT NULL,
    payment_date date,
    payment_method character varying(50),
    status character varying(20) DEFAULT 'pending'::character varying,
    remarks text,
    created_by integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.payroll OWNER TO neondb_owner;

--
-- Name: payroll_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.payroll_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.payroll_id_seq OWNER TO neondb_owner;

--
-- Name: payroll_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.payroll_id_seq OWNED BY public.payroll.id;


--
-- Name: purchase_order_items; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.purchase_order_items (
    id integer NOT NULL,
    po_id integer NOT NULL,
    item_id integer NOT NULL,
    quantity integer NOT NULL,
    unit_price numeric(10,2),
    total_price numeric(10,2),
    received_quantity integer DEFAULT 0,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.purchase_order_items OWNER TO neondb_owner;

--
-- Name: purchase_order_items_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.purchase_order_items_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.purchase_order_items_id_seq OWNER TO neondb_owner;

--
-- Name: purchase_order_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.purchase_order_items_id_seq OWNED BY public.purchase_order_items.id;


--
-- Name: purchase_orders; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.purchase_orders (
    id integer NOT NULL,
    po_number character varying(50) NOT NULL,
    supplier_id integer NOT NULL,
    order_date date NOT NULL,
    expected_delivery date,
    actual_delivery date,
    total_amount numeric(10,2),
    status character varying(20) DEFAULT 'pending'::character varying,
    created_by integer,
    approved_by integer,
    remarks text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.purchase_orders OWNER TO neondb_owner;

--
-- Name: purchase_orders_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.purchase_orders_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.purchase_orders_id_seq OWNER TO neondb_owner;

--
-- Name: purchase_orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.purchase_orders_id_seq OWNED BY public.purchase_orders.id;


--
-- Name: question_bank; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.question_bank (
    id integer NOT NULL,
    subject_id integer,
    class_id integer,
    question_text text NOT NULL,
    question_type character varying(50),
    difficulty_level character varying(50),
    marks integer,
    option_a character varying(255),
    option_b character varying(255),
    option_c character varying(255),
    option_d character varying(255),
    correct_answer character varying(50),
    explanation text,
    chapter_topic character varying(255),
    keywords text,
    status character varying(50) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone
);


ALTER TABLE public.question_bank OWNER TO neondb_owner;

--
-- Name: question_bank_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.question_bank_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.question_bank_id_seq OWNER TO neondb_owner;

--
-- Name: question_bank_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.question_bank_id_seq OWNED BY public.question_bank.id;


--
-- Name: quiz_attempts; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.quiz_attempts (
    id integer NOT NULL,
    quiz_id integer NOT NULL,
    student_id integer NOT NULL,
    start_time timestamp without time zone NOT NULL,
    end_time timestamp without time zone,
    marks_obtained integer,
    total_marks integer,
    percentage numeric(5,2),
    status character varying(20) DEFAULT 'in_progress'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.quiz_attempts OWNER TO neondb_owner;

--
-- Name: quiz_attempts_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.quiz_attempts_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.quiz_attempts_id_seq OWNER TO neondb_owner;

--
-- Name: quiz_attempts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.quiz_attempts_id_seq OWNED BY public.quiz_attempts.id;


--
-- Name: quiz_questions; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.quiz_questions (
    id integer NOT NULL,
    quiz_id integer NOT NULL,
    question_id integer NOT NULL,
    question_order integer NOT NULL,
    marks integer DEFAULT 1,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.quiz_questions OWNER TO neondb_owner;

--
-- Name: quiz_questions_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.quiz_questions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.quiz_questions_id_seq OWNER TO neondb_owner;

--
-- Name: quiz_questions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.quiz_questions_id_seq OWNED BY public.quiz_questions.id;


--
-- Name: quizzes; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.quizzes (
    id integer NOT NULL,
    title character varying(255) NOT NULL,
    subject_id integer NOT NULL,
    class_id integer NOT NULL,
    teacher_id integer NOT NULL,
    description text,
    duration_minutes integer DEFAULT 30,
    total_marks integer DEFAULT 10,
    passing_marks integer,
    start_time timestamp without time zone,
    end_time timestamp without time zone,
    status character varying(20) DEFAULT 'draft'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.quizzes OWNER TO neondb_owner;

--
-- Name: quizzes_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.quizzes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.quizzes_id_seq OWNER TO neondb_owner;

--
-- Name: quizzes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.quizzes_id_seq OWNED BY public.quizzes.id;


--
-- Name: recruitment_positions; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.recruitment_positions (
    id integer NOT NULL,
    title character varying(255) NOT NULL,
    department character varying(255) NOT NULL,
    description text,
    requirements text,
    number_of_positions integer DEFAULT 1,
    status character varying(50) DEFAULT 'open'::character varying,
    created_by integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.recruitment_positions OWNER TO neondb_owner;

--
-- Name: recruitment_positions_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.recruitment_positions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.recruitment_positions_id_seq OWNER TO neondb_owner;

--
-- Name: recruitment_positions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.recruitment_positions_id_seq OWNED BY public.recruitment_positions.id;


--
-- Name: roles; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.roles (
    id integer NOT NULL,
    name character varying(50) NOT NULL,
    display_name character varying(100) NOT NULL,
    description text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.roles OWNER TO neondb_owner;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.roles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_id_seq OWNER TO neondb_owner;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: route_stops; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.route_stops (
    id integer NOT NULL,
    route_id integer NOT NULL,
    stop_name character varying(255) NOT NULL,
    stop_order integer NOT NULL,
    pickup_time time without time zone,
    drop_time time without time zone,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.route_stops OWNER TO neondb_owner;

--
-- Name: route_stops_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.route_stops_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.route_stops_id_seq OWNER TO neondb_owner;

--
-- Name: route_stops_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.route_stops_id_seq OWNED BY public.route_stops.id;


--
-- Name: routes; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.routes (
    id integer NOT NULL,
    route_name character varying(100) NOT NULL,
    route_number character varying(50),
    start_point character varying(255),
    end_point character varying(255),
    distance numeric(10,2),
    fare numeric(10,2),
    vehicle_id integer,
    driver_id integer,
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.routes OWNER TO neondb_owner;

--
-- Name: routes_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.routes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.routes_id_seq OWNER TO neondb_owner;

--
-- Name: routes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.routes_id_seq OWNED BY public.routes.id;


--
-- Name: sms_logs; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.sms_logs (
    id integer NOT NULL,
    recipient_phone character varying(20) NOT NULL,
    recipient_name character varying(255),
    message_content text NOT NULL,
    sent_by integer,
    sent_at timestamp without time zone NOT NULL,
    status character varying(20) DEFAULT 'sent'::character varying,
    error_message text,
    provider character varying(50),
    cost numeric(10,2),
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.sms_logs OWNER TO neondb_owner;

--
-- Name: sms_logs_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.sms_logs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sms_logs_id_seq OWNER TO neondb_owner;

--
-- Name: sms_logs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.sms_logs_id_seq OWNED BY public.sms_logs.id;


--
-- Name: staff; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.staff (
    id integer NOT NULL,
    user_id integer NOT NULL,
    employee_id character varying(50) NOT NULL,
    designation character varying(100) NOT NULL,
    department character varying(100),
    qualification character varying(200),
    experience_years integer,
    joining_date date NOT NULL,
    salary numeric(10,2),
    bank_name character varying(100),
    account_number character varying(50),
    emergency_contact character varying(20),
    documents json,
    status character varying(50) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    department_id integer,
    CONSTRAINT staff_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying, 'on_leave'::character varying, 'resigned'::character varying])::text[])))
);


ALTER TABLE public.staff OWNER TO neondb_owner;

--
-- Name: staff_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.staff_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.staff_id_seq OWNER TO neondb_owner;

--
-- Name: staff_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.staff_id_seq OWNED BY public.staff.id;


--
-- Name: students; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.students (
    id integer NOT NULL,
    user_id integer NOT NULL,
    admission_number character varying(50) NOT NULL,
    class_id integer,
    roll_number character varying(20),
    admission_date date NOT NULL,
    guardian_name character varying(100),
    guardian_phone character varying(20),
    guardian_email character varying(100),
    guardian_relation character varying(50),
    previous_school character varying(200),
    blood_group character varying(5),
    medical_conditions text,
    documents json,
    status character varying(50) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT students_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying, 'graduated'::character varying, 'expelled'::character varying])::text[])))
);


ALTER TABLE public.students OWNER TO neondb_owner;

--
-- Name: students_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.students_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.students_id_seq OWNER TO neondb_owner;

--
-- Name: students_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.students_id_seq OWNED BY public.students.id;


--
-- Name: subjects; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.subjects (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    code character varying(20) NOT NULL,
    course_id integer,
    teacher_id integer,
    class_id integer,
    credits integer,
    type character varying(50) DEFAULT 'theory'::character varying,
    description text,
    status character varying(50) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT subjects_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[]))),
    CONSTRAINT subjects_type_check CHECK (((type)::text = ANY ((ARRAY['theory'::character varying, 'practical'::character varying, 'both'::character varying])::text[])))
);


ALTER TABLE public.subjects OWNER TO neondb_owner;

--
-- Name: subjects_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.subjects_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.subjects_id_seq OWNER TO neondb_owner;

--
-- Name: subjects_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.subjects_id_seq OWNED BY public.subjects.id;


--
-- Name: suppliers; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.suppliers (
    id integer NOT NULL,
    supplier_code character varying(50) NOT NULL,
    name character varying(255) NOT NULL,
    contact_person character varying(255),
    email character varying(255),
    phone character varying(20),
    address text,
    city character varying(100),
    country character varying(100),
    payment_terms text,
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.suppliers OWNER TO neondb_owner;

--
-- Name: suppliers_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.suppliers_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.suppliers_id_seq OWNER TO neondb_owner;

--
-- Name: suppliers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.suppliers_id_seq OWNED BY public.suppliers.id;


--
-- Name: support_messages; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.support_messages (
    id integer NOT NULL,
    user_id integer NOT NULL,
    subject character varying(255) NOT NULL,
    message text NOT NULL,
    status character varying(50) DEFAULT 'open'::character varying,
    admin_reply text,
    admin_replied_by integer,
    replied_at timestamp without time zone,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.support_messages OWNER TO neondb_owner;

--
-- Name: support_messages_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.support_messages_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.support_messages_id_seq OWNER TO neondb_owner;

--
-- Name: support_messages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.support_messages_id_seq OWNED BY public.support_messages.id;


--
-- Name: syllabuses; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.syllabuses (
    id integer NOT NULL,
    subject_id integer NOT NULL,
    class_id integer NOT NULL,
    academic_year character varying(20),
    title character varying(255) NOT NULL,
    description text,
    topics text,
    learning_objectives text,
    duration_hours integer,
    file_path character varying(255),
    created_by integer,
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    overview text,
    learning_outcomes text,
    topics_covered text,
    assessment_methods text,
    grading_scale character varying(255),
    recommended_resources text,
    prerequisites character varying(255),
    duration character varying(100)
);


ALTER TABLE public.syllabuses OWNER TO neondb_owner;

--
-- Name: syllabuses_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.syllabuses_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.syllabuses_id_seq OWNER TO neondb_owner;

--
-- Name: syllabuses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.syllabuses_id_seq OWNED BY public.syllabuses.id;


--
-- Name: system_settings; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.system_settings (
    id integer NOT NULL,
    setting_key character varying(100) NOT NULL,
    setting_value text,
    setting_type character varying(50),
    category character varying(100),
    description text,
    is_editable boolean DEFAULT true,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.system_settings OWNER TO neondb_owner;

--
-- Name: system_settings_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.system_settings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.system_settings_id_seq OWNER TO neondb_owner;

--
-- Name: system_settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.system_settings_id_seq OWNED BY public.system_settings.id;


--
-- Name: timetables; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.timetables (
    id integer NOT NULL,
    class_id integer NOT NULL,
    subject_id integer NOT NULL,
    teacher_id integer,
    day_of_week character varying(50) NOT NULL,
    start_time time without time zone NOT NULL,
    end_time time without time zone NOT NULL,
    room_number character varying(20),
    academic_year character varying(20) NOT NULL,
    semester character varying(20),
    status character varying(50) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT timetables_day_of_week_check CHECK (((day_of_week)::text = ANY ((ARRAY['monday'::character varying, 'tuesday'::character varying, 'wednesday'::character varying, 'thursday'::character varying, 'friday'::character varying, 'saturday'::character varying, 'sunday'::character varying])::text[]))),
    CONSTRAINT timetables_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying])::text[])))
);


ALTER TABLE public.timetables OWNER TO neondb_owner;

--
-- Name: timetables_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.timetables_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.timetables_id_seq OWNER TO neondb_owner;

--
-- Name: timetables_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.timetables_id_seq OWNED BY public.timetables.id;


--
-- Name: transport_assignments; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.transport_assignments (
    id integer NOT NULL,
    student_id integer NOT NULL,
    route_id integer NOT NULL,
    stop_id integer,
    start_date date NOT NULL,
    end_date date,
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.transport_assignments OWNER TO neondb_owner;

--
-- Name: transport_assignments_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.transport_assignments_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.transport_assignments_id_seq OWNER TO neondb_owner;

--
-- Name: transport_assignments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.transport_assignments_id_seq OWNED BY public.transport_assignments.id;


--
-- Name: user_roles; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.user_roles (
    id integer NOT NULL,
    user_id integer NOT NULL,
    role_id integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.user_roles OWNER TO neondb_owner;

--
-- Name: user_roles_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.user_roles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.user_roles_id_seq OWNER TO neondb_owner;

--
-- Name: user_roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.user_roles_id_seq OWNED BY public.user_roles.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying(100) NOT NULL,
    phone character varying(20),
    password character varying(255) NOT NULL,
    first_name character varying(50) NOT NULL,
    last_name character varying(50) NOT NULL,
    gender character varying(50),
    date_of_birth date,
    address text,
    photo character varying(255),
    status character varying(50) DEFAULT 'active'::character varying,
    email_verified_at timestamp without time zone,
    remember_token character varying(100),
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT users_gender_check CHECK (((gender)::text = ANY ((ARRAY['male'::character varying, 'female'::character varying, 'other'::character varying])::text[]))),
    CONSTRAINT users_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying, 'suspended'::character varying])::text[])))
);


ALTER TABLE public.users OWNER TO neondb_owner;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO neondb_owner;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: vehicle_maintenance; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.vehicle_maintenance (
    id integer NOT NULL,
    vehicle_id integer NOT NULL,
    maintenance_type character varying(100),
    description text,
    maintenance_date date NOT NULL,
    cost numeric(10,2),
    vendor character varying(255),
    next_maintenance_date date,
    status character varying(20) DEFAULT 'completed'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.vehicle_maintenance OWNER TO neondb_owner;

--
-- Name: vehicle_maintenance_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.vehicle_maintenance_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.vehicle_maintenance_id_seq OWNER TO neondb_owner;

--
-- Name: vehicle_maintenance_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.vehicle_maintenance_id_seq OWNED BY public.vehicle_maintenance.id;


--
-- Name: vehicles; Type: TABLE; Schema: public; Owner: neondb_owner
--

CREATE TABLE public.vehicles (
    id integer NOT NULL,
    vehicle_number character varying(50) NOT NULL,
    vehicle_type character varying(50),
    model character varying(100),
    manufacturer character varying(100),
    year integer,
    capacity integer,
    fuel_type character varying(50),
    registration_date date,
    insurance_expiry date,
    fitness_expiry date,
    status character varying(20) DEFAULT 'active'::character varying,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.vehicles OWNER TO neondb_owner;

--
-- Name: vehicles_id_seq; Type: SEQUENCE; Schema: public; Owner: neondb_owner
--

CREATE SEQUENCE public.vehicles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.vehicles_id_seq OWNER TO neondb_owner;

--
-- Name: vehicles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: neondb_owner
--

ALTER SEQUENCE public.vehicles_id_seq OWNED BY public.vehicles.id;


--
-- Name: academic_calendar id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.academic_calendar ALTER COLUMN id SET DEFAULT nextval('public.academic_calendar_id_seq'::regclass);


--
-- Name: admissions id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.admissions ALTER COLUMN id SET DEFAULT nextval('public.admissions_id_seq'::regclass);


--
-- Name: announcements id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.announcements ALTER COLUMN id SET DEFAULT nextval('public.announcements_id_seq'::regclass);


--
-- Name: assets id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assets ALTER COLUMN id SET DEFAULT nextval('public.assets_id_seq'::regclass);


--
-- Name: assignment_submissions id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assignment_submissions ALTER COLUMN id SET DEFAULT nextval('public.assignment_submissions_id_seq'::regclass);


--
-- Name: assignments id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assignments ALTER COLUMN id SET DEFAULT nextval('public.assignments_id_seq'::regclass);


--
-- Name: attendance id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.attendance ALTER COLUMN id SET DEFAULT nextval('public.attendance_id_seq'::regclass);


--
-- Name: audit_logs id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.audit_logs ALTER COLUMN id SET DEFAULT nextval('public.audit_logs_id_seq'::regclass);


--
-- Name: book_issues id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.book_issues ALTER COLUMN id SET DEFAULT nextval('public.book_issues_id_seq'::regclass);


--
-- Name: books id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.books ALTER COLUMN id SET DEFAULT nextval('public.books_id_seq'::regclass);


--
-- Name: budget id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.budget ALTER COLUMN id SET DEFAULT nextval('public.budget_id_seq'::regclass);


--
-- Name: budgets id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.budgets ALTER COLUMN id SET DEFAULT nextval('public.budgets_id_seq'::regclass);


--
-- Name: calendar_events id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.calendar_events ALTER COLUMN id SET DEFAULT nextval('public.calendar_events_id_seq'::regclass);


--
-- Name: classes id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.classes ALTER COLUMN id SET DEFAULT nextval('public.classes_id_seq'::regclass);


--
-- Name: courses id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.courses ALTER COLUMN id SET DEFAULT nextval('public.courses_id_seq'::regclass);


--
-- Name: database_backups id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.database_backups ALTER COLUMN id SET DEFAULT nextval('public.database_backups_id_seq'::regclass);


--
-- Name: departments id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.departments ALTER COLUMN id SET DEFAULT nextval('public.departments_id_seq'::regclass);


--
-- Name: email_logs id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.email_logs ALTER COLUMN id SET DEFAULT nextval('public.email_logs_id_seq'::regclass);


--
-- Name: exams id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.exams ALTER COLUMN id SET DEFAULT nextval('public.exams_id_seq'::regclass);


--
-- Name: expenses id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.expenses ALTER COLUMN id SET DEFAULT nextval('public.expenses_id_seq'::regclass);


--
-- Name: fee_structure_templates id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.fee_structure_templates ALTER COLUMN id SET DEFAULT nextval('public.fee_structure_templates_id_seq'::regclass);


--
-- Name: fees_structures id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.fees_structures ALTER COLUMN id SET DEFAULT nextval('public.fees_structures_id_seq'::regclass);


--
-- Name: forum_posts id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.forum_posts ALTER COLUMN id SET DEFAULT nextval('public.forum_posts_id_seq'::regclass);


--
-- Name: forums id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.forums ALTER COLUMN id SET DEFAULT nextval('public.forums_id_seq'::regclass);


--
-- Name: holidays id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.holidays ALTER COLUMN id SET DEFAULT nextval('public.holidays_id_seq'::regclass);


--
-- Name: hostel_complaints id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_complaints ALTER COLUMN id SET DEFAULT nextval('public.hostel_complaints_id_seq'::regclass);


--
-- Name: hostel_residents id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_residents ALTER COLUMN id SET DEFAULT nextval('public.hostel_residents_id_seq'::regclass);


--
-- Name: hostel_rooms id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_rooms ALTER COLUMN id SET DEFAULT nextval('public.hostel_rooms_id_seq'::regclass);


--
-- Name: hostel_visitors id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_visitors ALTER COLUMN id SET DEFAULT nextval('public.hostel_visitors_id_seq'::regclass);


--
-- Name: hostels id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostels ALTER COLUMN id SET DEFAULT nextval('public.hostels_id_seq'::regclass);


--
-- Name: hr_events id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hr_events ALTER COLUMN id SET DEFAULT nextval('public.hr_events_id_seq'::regclass);


--
-- Name: integrations id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.integrations ALTER COLUMN id SET DEFAULT nextval('public.integrations_id_seq'::regclass);


--
-- Name: inventory_items id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.inventory_items ALTER COLUMN id SET DEFAULT nextval('public.inventory_items_id_seq'::regclass);


--
-- Name: invoices id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.invoices ALTER COLUMN id SET DEFAULT nextval('public.invoices_id_seq'::regclass);


--
-- Name: leave_applications id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leave_applications ALTER COLUMN id SET DEFAULT nextval('public.leave_applications_id_seq'::regclass);


--
-- Name: leave_balances id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leave_balances ALTER COLUMN id SET DEFAULT nextval('public.leave_balances_id_seq'::regclass);


--
-- Name: leave_types id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leave_types ALTER COLUMN id SET DEFAULT nextval('public.leave_types_id_seq'::regclass);


--
-- Name: leaves id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leaves ALTER COLUMN id SET DEFAULT nextval('public.leaves_id_seq'::regclass);


--
-- Name: lesson_plans id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.lesson_plans ALTER COLUMN id SET DEFAULT nextval('public.lesson_plans_id_seq'::regclass);


--
-- Name: library_members id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.library_members ALTER COLUMN id SET DEFAULT nextval('public.library_members_id_seq'::regclass);


--
-- Name: marks id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.marks ALTER COLUMN id SET DEFAULT nextval('public.marks_id_seq'::regclass);


--
-- Name: materials id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.materials ALTER COLUMN id SET DEFAULT nextval('public.materials_id_seq'::regclass);


--
-- Name: mess_menu id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.mess_menu ALTER COLUMN id SET DEFAULT nextval('public.mess_menu_id_seq'::regclass);


--
-- Name: messages id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.messages ALTER COLUMN id SET DEFAULT nextval('public.messages_id_seq'::regclass);


--
-- Name: notifications id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.notifications ALTER COLUMN id SET DEFAULT nextval('public.notifications_id_seq'::regclass);


--
-- Name: otp_resets id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.otp_resets ALTER COLUMN id SET DEFAULT nextval('public.otp_resets_id_seq'::regclass);


--
-- Name: payroll id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.payroll ALTER COLUMN id SET DEFAULT nextval('public.payroll_id_seq'::regclass);


--
-- Name: purchase_order_items id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.purchase_order_items ALTER COLUMN id SET DEFAULT nextval('public.purchase_order_items_id_seq'::regclass);


--
-- Name: purchase_orders id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.purchase_orders ALTER COLUMN id SET DEFAULT nextval('public.purchase_orders_id_seq'::regclass);


--
-- Name: question_bank id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.question_bank ALTER COLUMN id SET DEFAULT nextval('public.question_bank_id_seq'::regclass);


--
-- Name: quiz_attempts id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.quiz_attempts ALTER COLUMN id SET DEFAULT nextval('public.quiz_attempts_id_seq'::regclass);


--
-- Name: quiz_questions id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.quiz_questions ALTER COLUMN id SET DEFAULT nextval('public.quiz_questions_id_seq'::regclass);


--
-- Name: quizzes id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.quizzes ALTER COLUMN id SET DEFAULT nextval('public.quizzes_id_seq'::regclass);


--
-- Name: recruitment_positions id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.recruitment_positions ALTER COLUMN id SET DEFAULT nextval('public.recruitment_positions_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: route_stops id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.route_stops ALTER COLUMN id SET DEFAULT nextval('public.route_stops_id_seq'::regclass);


--
-- Name: routes id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.routes ALTER COLUMN id SET DEFAULT nextval('public.routes_id_seq'::regclass);


--
-- Name: sms_logs id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.sms_logs ALTER COLUMN id SET DEFAULT nextval('public.sms_logs_id_seq'::regclass);


--
-- Name: staff id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.staff ALTER COLUMN id SET DEFAULT nextval('public.staff_id_seq'::regclass);


--
-- Name: students id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.students ALTER COLUMN id SET DEFAULT nextval('public.students_id_seq'::regclass);


--
-- Name: subjects id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.subjects ALTER COLUMN id SET DEFAULT nextval('public.subjects_id_seq'::regclass);


--
-- Name: suppliers id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.suppliers ALTER COLUMN id SET DEFAULT nextval('public.suppliers_id_seq'::regclass);


--
-- Name: support_messages id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.support_messages ALTER COLUMN id SET DEFAULT nextval('public.support_messages_id_seq'::regclass);


--
-- Name: syllabuses id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.syllabuses ALTER COLUMN id SET DEFAULT nextval('public.syllabuses_id_seq'::regclass);


--
-- Name: system_settings id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.system_settings ALTER COLUMN id SET DEFAULT nextval('public.system_settings_id_seq'::regclass);


--
-- Name: timetables id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.timetables ALTER COLUMN id SET DEFAULT nextval('public.timetables_id_seq'::regclass);


--
-- Name: transport_assignments id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.transport_assignments ALTER COLUMN id SET DEFAULT nextval('public.transport_assignments_id_seq'::regclass);


--
-- Name: user_roles id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.user_roles ALTER COLUMN id SET DEFAULT nextval('public.user_roles_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: vehicle_maintenance id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.vehicle_maintenance ALTER COLUMN id SET DEFAULT nextval('public.vehicle_maintenance_id_seq'::regclass);


--
-- Name: vehicles id; Type: DEFAULT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.vehicles ALTER COLUMN id SET DEFAULT nextval('public.vehicles_id_seq'::regclass);


--
-- Data for Name: academic_calendar; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.academic_calendar (id, academic_year, start_date, end_date, session_name, session_start, session_end, exam_start, exam_end, admission_start, admission_end, holidays, important_events, status, notes, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: admissions; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.admissions (id, application_number, first_name, last_name, email, phone, date_of_birth, gender, address, course_id, class_id, guardian_name, guardian_phone, guardian_email, previous_school, documents, status, remarks, reviewed_by, reviewed_at, created_at, updated_at) FROM stdin;
1	ADM20250001	Jatin	Sharma	jatinkumarsharma2040@gmail.com	7465066991	2005-02-09	male	sdfjsdjflsalkfjlsj	\N	30	jatin	7465066991			\N	approved	Application approved	1	2025-11-28 09:41:12.544533	2025-11-28 09:40:36	2025-11-29 04:00:29.240837
2	ADM20250002	Jatin	Sharma	jatinkumarsharma2040@gmail.com	7465066991	2025-11-20	female	Main Road Jartoli Mod Jattari	33	\N	jatin	7465066991			\N	rejected	uhugjh	1	2025-11-28 09:42:27.074679	2025-11-28 09:42:02	2025-11-29 04:37:41.049963
3	ADM20250003	Jatin	Sharma	admin@school.com	8755106013	2025-11-06	female	Main Road Jartoli Mod Jattari	35	30	jatin	7465066991			\N	approved	Application approved	1	2025-11-29 08:31:34.535717	2025-11-28 09:43:35	2025-11-29 08:31:34.535717
5	ADM20250005	Jatin	Sharma	jatinkumarsharma2040@gmail.com	7465066991	2025-11-27	female	Main Road Jartoli Mod Jattari	31	30	jatin	7465066991			{"photo":"\\/uploads\\/admissions\\/692c27f9a1db7_1764501497.jpg","id_proof":"\\/uploads\\/admissions\\/692c27f9a1eea_1764501497.jpg","birth_certificate":"\\/uploads\\/admissions\\/692c27f9a1f90_1764501497.jpg"}	rejected	dsfsd	1	2025-11-30 11:18:57.083832	2025-11-30 11:18:17	2025-11-30 11:18:57.083832
4	ADM20250004	Jatin	sharma	jatinkumar2040@gmail.com	7465066991	2025-11-12	male	Main Road Jartoli Mod Jattari	32	30	jatin	7465066991			\N	completed	Application approved	1	2025-12-01 07:19:42.788522	2025-11-30 11:11:46	2025-12-01 07:19:42.788522
6	ADM20250006	Rohan	Brown	rohan@gmail.com	123424234223	2026-01-02	male	ttttttttttttttttt	40	30	dddddddd	1234567890	guardian@gmail.com	ddddddddddddddd	{"photo":"\\/uploads\\/admissions\\/692d42ce86c03_1764573902.png","id_proof":"\\/uploads\\/admissions\\/692d42ce878be_1764573902.png"}	waitlisted	kkkkkk	53	2025-12-01 07:28:52.143441	2025-12-01 07:25:02	2025-12-01 07:28:52.143441
\.


--
-- Data for Name: announcements; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.announcements (id, title, content, target_audience, priority, published_by, published_date, expiry_date, attachment_path, is_visible, views_count, created_at, updated_at) FROM stdin;
2	School Closed for Maintenance	The school will be closed on December 10-12 for annual maintenance. Classes will resume on December 15.	students	normal	53	2025-12-01 05:44:42.186469	2025-12-21 05:44:42.186469	\N	t	32	2025-12-01 05:44:42.186469	2025-12-01 05:44:42.186469
3	Results Announcement: Mid-Term Exams	Mid-term examination results are now available in the student portal. Parents are requested to review their child's performance.	parents	high	53	2025-12-01 05:44:42.186469	2025-12-16 05:44:42.186469	\N	t	156	2025-12-01 05:44:42.186469	2025-12-01 05:44:42.186469
4	Sports Day - Registration Open	Annual Sports Day will be held on January 15, 2026. All students are encouraged to register for various events. Last date for registration: December 20.	students	normal	53	2025-12-01 05:44:42.186469	2026-01-10 05:44:42.186469	\N	t	78	2025-12-01 05:44:42.186469	2025-12-01 05:44:42.186469
5	URGENT: Fee Payment Due by December 15	All pending fee payments must be submitted by December 15, 2025. Please contact the finance office for any queries.	parents	urgent	53	2025-12-01 05:44:42.186469	2025-12-06 05:44:42.186469	\N	t	203	2025-12-01 05:44:42.186469	2025-12-01 05:44:42.186469
6	New Library Opening - Grand Inauguration	We are excited to announce the opening of our newly renovated library with state-of-the-art facilities. Inauguration ceremony on December 20.	all	normal	53	2025-12-01 05:44:42.186469	2025-12-26 05:44:42.186469	\N	t	89	2025-12-01 05:44:42.186469	2025-12-01 05:44:42.186469
7	Teacher Professional Development Workshop	All staff members are required to attend the professional development workshop on January 5, 2026. Detailed schedule will be shared soon.	staff	high	53	2025-12-01 05:44:42.186469	2025-12-31 05:44:42.186469	\N	t	34	2025-12-01 05:44:42.186469	2025-12-01 05:44:42.186469
8	Admissions Open for 2026-27	Online admissions for the 2026-27 academic year are now open. Application deadline: March 31, 2026. Apply now on our website.	all	normal	53	2025-12-01 05:44:42.186469	2026-03-31 05:44:42.186469	\N	t	567	2025-12-01 05:44:42.186469	2025-12-01 05:44:42.186469
9	Updated COVID-19 Safety Guidelines	Please adhere to the latest COVID-19 safety guidelines issued by health authorities. Hand sanitizers are available at entry points.	all	normal	53	2025-12-01 05:44:42.186469	2026-01-30 05:44:42.186469	\N	t	12	2025-12-01 05:44:42.186469	2025-12-01 05:44:42.186469
10	Parent-Teacher Meeting Scheduled	Parent-teacher meetings will be held on December 28-29. Please book your slot through the school portal by December 18.	parents	normal	53	2025-12-01 05:44:42.186469	2025-12-21 05:44:42.186469	\N	t	145	2025-12-01 05:44:42.186469	2025-12-01 05:44:42.186469
11	rana	rana	students	high	53	2025-12-01 05:49:00	2026-01-01 11:19:00	\N	t	0	2025-12-01 05:49:30	2025-12-01 05:49:30
\.


--
-- Data for Name: assets; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.assets (id, asset_code, name, category, description, purchase_date, purchase_cost, current_value, depreciation_rate, location, assigned_to, condition, warranty_expiry, status, created_at, updated_at) FROM stdin;
3	AST-003	Samsung 65" Smart TV	Electronics	Display screen for conference room presentations	2024-03-10	120000.00	108000.00	10.00	Conference Room	\N	excellent	2027-03-10	active	2025-12-01 03:43:49.139908	2025-12-01 03:43:49.139908
4	AST-004	Executive Office Desk	Furniture	Premium wooden desk for principal office	2022-08-05	35000.00	26250.00	12.50	Principal Office	\N	good	\N	active	2025-12-01 03:43:49.139908	2025-12-01 03:43:49.139908
5	AST-005	Projector Epson EB-X51	Electronics	Classroom projector with 3800 lumens	2024-02-28	55000.00	49500.00	10.00	Classroom Block A	\N	excellent	2027-02-28	active	2025-12-01 03:43:49.139908	2025-12-01 03:43:49.139908
6	AST-006	Air Conditioner 2 Ton	Appliances	Split AC for computer lab cooling	2023-04-15	68000.00	54400.00	20.00	Computer Lab	\N	good	2028-04-15	active	2025-12-01 03:43:49.139908	2025-12-01 03:43:49.139908
7	AST-007	Biometric Attendance Machine	Electronics	Fingerprint-based attendance system	2024-01-01	25000.00	22500.00	10.00	Main Entrance	\N	excellent	2027-01-01	active	2025-12-01 03:43:49.139908	2025-12-01 03:43:49.139908
8	AST-008	Library Shelving Unit	Furniture	Metal book shelving system - 6 sections	2021-09-20	48000.00	32400.00	16.25	Library	\N	fair	\N	active	2025-12-01 03:43:49.139908	2025-12-01 03:43:49.139908
1	AST-001	Dell Latitude 5520 Laptop	Electronics	Business laptop for administrative staff	2024-01-15	85000.00	72250.00	15.00	Admin Office	51	good	2027-01-15	active	2025-12-01 03:43:49.139908	2025-12-01 03:59:33.294065
10	doooo	rana	Electronics	kkkkkkkkk	2025-12-25	66.00	66.00	44.00	Admin Office	54	good	2025-12-12	active	2025-12-01 04:12:13.769328	2025-12-01 04:12:13.769328
\.


--
-- Data for Name: assignment_submissions; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.assignment_submissions (id, assignment_id, student_id, submission_date, submission_text, attachment_path, marks_obtained, feedback, graded_by, graded_date, status, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: assignments; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.assignments (id, title, subject_id, class_id, teacher_id, description, instructions, attachment_path, assigned_date, due_date, total_marks, status, created_at, updated_at) FROM stdin;
1	Algebra Problem Set Chapter 5	48	30	1	Solve polynomial equations and inequalities	Complete all 25 questions from textbook. Show your work for each problem.	\N	2025-11-28	2025-12-05	50	active	2025-11-30 04:08:13.200839	2025-11-30 04:08:13.200839
2	Lab Report - Chemical Reactions	43	27	1	Document the three chemical reactions performed in class	Include introduction, procedure, observations, and conclusion. Use proper chemistry notation.	\N	2025-11-27	2025-12-07	40	active	2025-11-30 04:08:13.200839	2025-11-30 04:08:13.200839
4	Computer Programming Assignment - Functions	48	31	1	Create a program using functions in Python	Write functions to perform various calculations. Submit code with test cases.	\N	2025-11-29	2025-12-04	60	active	2025-11-30 04:08:13.200839	2025-11-30 04:08:13.200839
5	Biology Research Project - Photosynthesis	44	30	1	Research project on photosynthesis mechanisms	Create a comprehensive report with diagrams and experimental findings.	\N	2025-11-25	2025-12-08	80	active	2025-11-30 04:08:13.200839	2025-11-30 04:08:13.200839
6	rana	48	29	1	sredfdf	dfsddfd		2025-11-19	2025-11-06	100	active	2025-11-30 04:14:00.304514	2025-11-30 04:14:00.304514
\.


--
-- Data for Name: attendance; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.attendance (id, student_id, class_id, subject_id, date, period, status, remarks, marked_by, created_at, updated_at) FROM stdin;
1	25	31	\N	2025-11-29	\N	present	\N	1	2025-11-29 07:52:58	2025-11-29 07:52:58
2	30	31	\N	2025-11-29	\N	present	\N	1	2025-11-29 07:52:59	2025-11-29 07:52:59
3	26	27	\N	2025-11-29	\N	present	\N	1	2025-11-29 07:57:27	2025-11-29 07:57:27
4	31	27	\N	2025-11-29	\N	present	\N	1	2025-11-29 07:57:27	2025-11-29 07:57:27
\.


--
-- Data for Name: audit_logs; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.audit_logs (id, user_id, action, table_name, record_id, old_values, new_values, ip_address, user_agent, created_at) FROM stdin;
\.


--
-- Data for Name: book_issues; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.book_issues (id, book_id, user_id, issue_date, due_date, return_date, status, fine_amount, fine_paid, remarks, issued_by, returned_to, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: books; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.books (id, isbn, title, author, publisher, publication_year, category, total_copies, available_copies, location, price, description, cover_image, status, created_at, updated_at) FROM stdin;
1	978-0262033848	Introduction to Algorithms	Thomas Cormen	\N	\N	\N	5	5	\N	\N	\N	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
2	978-0132350884	Clean Code	Robert Martin	\N	\N	\N	5	5	\N	\N	\N	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
3	978-0201633612	Design Patterns	Gang of Four	\N	\N	\N	5	5	\N	\N	\N	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
4	978-0135957059	The Pragmatic Programmer	Hunt & Thomas	\N	\N	\N	5	5	\N	\N	\N	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
5	978-0735619678	Code Complete	Steve McConnell	\N	\N	\N	5	5	\N	\N	\N	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
\.


--
-- Data for Name: budget; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.budget (id, budget_number, category, description, allocated_amount, spent_amount, academic_year, period, status, created_by, created_at, updated_at) FROM stdin;
1	BUD-2024-0001	Academic	Teaching materials and course development	500000.00	250000.00	2024-2025	Annual	active	1	2025-11-30 03:55:16.891163	2025-11-30 03:55:16.891163
3	BUD-2024-0003	Infrastructure	Building maintenance and repairs	800000.00	400000.00	2024-2025	Annual	active	1	2025-11-30 03:55:16.891163	2025-11-30 03:55:16.891163
4	BUD-2024-0004	Technology	IT equipment and software licenses	350000.00	175000.00	2024-2025	Annual	active	1	2025-11-30 03:55:16.891163	2025-11-30 03:55:16.891163
5	BUD-2024-0005	Utilities	Electricity, water, and internet services	300000.00	150000.00	2024-2025	Annual	active	1	2025-11-30 03:55:16.891163	2025-11-30 03:55:16.891163
6	BUD-2024-0006	Administrative	Office supplies and administrative expenses	200000.00	100000.00	2024-2025	Annual	active	1	2025-11-30 03:55:16.891163	2025-11-30 03:55:16.891163
7	BUD-2024-0007	Events	Annual events and programs	150000.00	50000.00	2024-2025	Annual	pending	1	2025-11-30 03:55:16.891163	2025-11-30 03:55:16.891163
8	BUD-2024-0008	Maintenance	Facility maintenance and cleaning	250000.00	100000.00	2024-2025	Annual	active	1	2025-11-30 03:55:16.891163	2025-11-30 03:55:16.891163
9	BUD-2024-0009	Academic	Library books and resources	100000.00	30000.00	2024-2025	Semester	active	1	2025-11-30 03:55:16.891163	2025-11-30 03:55:16.891163
10	BUD-2024-0010	Infrastructure	Lab equipment and apparatus	400000.00	200000.00	2024-2025	Annual	active	1	2025-11-30 03:55:16.891163	2025-11-30 03:55:16.891163
11	BUD-2025-0001	Administrative	kuyiu	300000.00	50000.00	2025	Quarterly	active	1	2025-11-30 04:01:10.306557	2025-11-30 04:01:10.306557
\.


--
-- Data for Name: budgets; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.budgets (id, budget_name, category, fiscal_year, allocated_amount, spent_amount, remaining_amount, department, status, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: calendar_events; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.calendar_events (id, title, description, event_date, start_time, end_time, location, event_type, created_by, created_at, updated_at) FROM stdin;
1	Annual Sports Day	Inter-class sports competition	2025-12-10	09:00:00	16:00:00	Main Ground	event	34	2025-11-30 06:38:24.230721	2025-11-30 06:38:24.230721
2	Science Exhibition	Annual science fair and exhibition	2025-12-20	10:00:00	15:00:00	School Auditorium	event	34	2025-11-30 06:38:24.230721	2025-11-30 06:38:24.230721
3	Parent-Teacher Meeting	Quarterly PTM session	2025-12-05	14:00:00	17:00:00	School Hall	meeting	34	2025-11-30 06:38:24.230721	2025-11-30 06:38:24.230721
4	Final Exam Schedule	Board exams begin	2025-12-30	10:00:00	13:00:00	Class Rooms	exam	34	2025-11-30 06:38:24.230721	2025-11-30 06:38:24.230721
6	rana	liyi	2025-11-13	14:10:00	16:10:00	School Auditorium	meeting	1	2025-11-30 06:40:51.043573	2025-11-30 06:40:51.043573
\.


--
-- Data for Name: classes; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.classes (id, name, code, course_id, section, academic_year, capacity, room_number, status, created_at, updated_at) FROM stdin;
30	Class 4	CLS004	\N	D	2024-2025	50	\N	active	2025-11-26 05:07:16.955887	2025-11-29 04:00:29.240837
27	Class 1	CLS001	31	A	2024-2025	50		active	2025-11-26 05:07:16.955887	2025-11-29 04:29:55.49845
29	Class 3	CLS003	\N	C	2024-2025	50		inactive	2025-11-26 05:07:16.955887	2025-11-29 04:41:51.66455
31	Class 55	CLS005	35	E	2024-2025	50		active	2025-11-26 05:07:16.955887	2025-11-29 04:42:24.253274
\.


--
-- Data for Name: courses; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.courses (id, name, code, description, duration_years, status, created_at, updated_at) FROM stdin;
35	Master of Arts	MA	Postgraduate arts program	2	active	2025-11-26 05:07:16.955887	2025-11-29 03:51:06.982932
31	Bachelor of Science 1	BSC	Science degree program hj	9	active	2025-11-26 05:07:16.955887	2025-11-29 03:53:51.56174
32	Bachelor of Arts	BA	Arts degree program	3	active	2025-11-26 05:07:16.955887	2025-11-29 03:53:51.56174
33	Bachelor of Commerce	BCOM	Commerce degree program	9	inactive	2025-11-26 05:07:16.955887	2025-11-29 04:10:15.854385
40	rana	ex-1	jkjj	3	active	2025-11-29 04:10:36	2025-11-29 04:10:36
\.


--
-- Data for Name: database_backups; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.database_backups (id, backup_name, backup_path, backup_size, backup_type, created_by, status, error_message, created_at) FROM stdin;
\.


--
-- Data for Name: departments; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.departments (id, name, code, description, head_id, parent_department_id, email, phone, location, budget, status, created_at, updated_at) FROM stdin;
1	Computer Science	CS		\N	\N	\N	\N	\N	\N	active	2025-11-30 11:37:00.296394	2025-11-30 11:37:00.296394
\.


--
-- Data for Name: email_logs; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.email_logs (id, recipient_email, recipient_name, subject, email_body, sent_by, sent_at, status, error_message, created_at) FROM stdin;
\.


--
-- Data for Name: exams; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.exams (id, name, code, class_id, exam_type, academic_year, semester, start_date, end_date, total_marks, passing_marks, status, created_at, updated_at) FROM stdin;
3	Mid Term 2	EX002	\N	midterm	2024-2025	\N	2025-12-26	2025-12-31	100	40	scheduled	2025-11-26 05:07:16.955887	2025-11-30 01:45:04.854919
\.


--
-- Data for Name: expenses; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.expenses (id, expense_number, category, description, amount, expense_date, payment_method, vendor, invoice_number, approved_by, status, created_by, created_at, updated_at) FROM stdin;
2	EXP-2024-0002	Equipment	New desktop computers for computer lab upgrade	125000.00	2024-11-27	Credit Card	Tech Solutions Ltd	INV-2024-5002	\N	approved	1	2025-11-30 03:36:14.789765	2025-11-30 03:36:14.789765
3	EXP-2024-0003	Utilities	Monthly electricity bill for November	38500.00	2024-11-26	Bank Transfer	State Electricity Board	BILL-2024-11	\N	approved	1	2025-11-30 03:36:14.789765	2025-11-30 03:36:14.789765
4	EXP-2024-0004	Maintenance	Roof repair and maintenance work	22000.00	2024-11-25	Cash	BuildRight Construction	INV-2024-5003	\N	pending	1	2025-11-30 03:36:14.789765	2025-11-30 03:36:14.789765
5	EXP-2024-0005	Travel	Staff travel expenses for annual conference in Delhi	18500.00	2024-11-24	Credit Card	MakeMyTrip	TXN-2024-456	\N	approved	1	2025-11-30 03:36:14.789765	2025-11-30 03:36:14.789765
6	EXP-2024-0006	Other	Professional development workshop for teachers	12000.00	2024-11-23	Bank Transfer	EdTech Training Institute	INV-2024-5004	\N	pending	1	2025-11-30 03:36:14.789765	2025-11-30 03:36:14.789765
7	EXP-2024-0007	Supplies	Classroom furniture and desks	45000.00	2024-11-22	Check	Furniture Plus	CHQ-2024-789	\N	approved	1	2025-11-30 03:36:14.789765	2025-11-30 03:36:14.789765
8	EXP-2024-0008	Equipment	Projectors and audio-visual equipment for classrooms	85000.00	2024-11-21	Bank Transfer	AV Solutions	INV-2024-5005	\N	approved	1	2025-11-30 03:36:14.789765	2025-11-30 03:36:14.789765
9	EXP-2024-0009	Maintenance	Painting and wall repair - Building B	15000.00	2024-11-20	Cash	Pro Painters	INV-2024-5006	\N	rejected	1	2025-11-30 03:36:14.789765	2025-11-30 03:36:14.789765
10	EXP-2024-0010	Travel	Transport for student field trip to museum	8500.00	2024-11-19	Cash	City Tours Bus Service	PASS-2024-123	\N	approved	1	2025-11-30 03:36:14.789765	2025-11-30 03:36:14.789765
11	EXP-2025-1225	Equipment	tyuyututyut	30000.00	2025-11-30	Cash	ABC Office Supplies	INV-2024-5001	\N	approved	1	2025-11-30 03:40:19.049484	2025-11-30 03:40:19.049484
\.


--
-- Data for Name: fee_structure_templates; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.fee_structure_templates (id, name, class_id, academic_year, amount, due_date, fine_per_day, description, status, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: fees_structures; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.fees_structures (id, name, class_id, course_id, academic_year, semester, fee_type, amount, due_date, status, created_at, updated_at) FROM stdin;
2	Exam Fee - Class 1	27	\N	2024-2025	1st	exam	500.00	2024-07-15	active	2025-11-30 02:40:20.7241	2025-11-30 02:40:20.7241
3	Library Fee - Class 1	27	\N	2024-2025	1st	library	200.00	2024-06-30	active	2025-11-30 02:40:20.7241	2025-11-30 02:40:20.7241
4	Lab Fee - Class 1	27	\N	2024-2025	1st	lab	800.00	2024-07-15	active	2025-11-30 02:40:20.7241	2025-11-30 02:40:20.7241
5	Tuition Fee - Class 3	29	\N	2024-2025	1st	tuition	5500.00	2024-06-30	active	2025-11-30 02:40:20.7241	2025-11-30 02:40:20.7241
6	Transport Fee - Class 3	29	\N	2024-2025	1st	transport	1200.00	2024-06-30	active	2025-11-30 02:40:20.7241	2025-11-30 02:40:20.7241
7	Tuition Fee - Class 4	30	\N	2024-2025	1st	tuition	6000.00	2024-06-30	active	2025-11-30 02:40:20.7241	2025-11-30 02:40:20.7241
8	Hostel Fee - Class 4	30	\N	2024-2025	1st	hostel	3000.00	2024-06-30	active	2025-11-30 02:40:20.7241	2025-11-30 02:40:20.7241
9	rana	\N	\N	2024-2025	\N	transport	2000.00	2025-12-06	active	2025-11-30 03:28:31	2025-11-30 03:28:31
1	Tuition Fee - Class 1	27	\N	2024-2025	1st	tuition	5000.00	2024-06-30	inactive	2025-11-30 02:40:20.7241	2025-11-30 03:33:06.833444
\.


--
-- Data for Name: forum_posts; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.forum_posts (id, forum_id, parent_post_id, user_id, post_content, attachment_path, likes_count, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: forums; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.forums (id, title, subject_id, class_id, description, created_by, status, created_at, updated_at) FROM stdin;
2	Study Groups	44	30	Find study partners and form study groups for exam preparation	34	active	2025-11-30 06:30:18.33047	2025-11-30 06:30:18.33047
3	Assignment Help	45	29	Ask questions and get help with assignments and coursework	34	active	2025-11-30 06:30:18.33047	2025-11-30 06:30:18.33047
4	Doubt Clearing	47	31	Clear your doubts and get clarification on difficult concepts	34	active	2025-11-30 06:30:18.33047	2025-11-30 06:30:18.33047
5	Announcements & Updates	\N	\N	Important announcements and updates for all students	34	active	2025-11-30 06:30:18.33047	2025-11-30 06:30:18.33047
\.


--
-- Data for Name: holidays; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.holidays (id, name, description, start_date, end_date, holiday_type, status, created_by, created_at, updated_at) FROM stdin;
1	Diwali	Festival of lights - major celebration	2025-12-15	2025-12-17	festival	active	34	2025-11-30 06:44:15.661328	2025-11-30 06:44:15.661328
2	Christmas	Christmas holiday break	2026-01-19	2026-01-24	holiday	active	34	2025-11-30 06:44:15.661328	2025-11-30 06:44:15.661328
3	New Year	New Year celebration and break	2026-01-29	2026-01-31	holiday	active	34	2025-11-30 06:44:15.661328	2025-11-30 06:44:15.661328
5	Teacher Training Day	Professional development for teachers	2025-12-25	2025-12-26	special	active	34	2025-11-30 06:44:15.661328	2025-11-30 06:44:15.661328
6	rana	loiu;ou;u;po	2025-11-13	2025-11-27	festival	active	1	2025-11-30 06:47:24.068351	2025-11-30 06:47:24.068351
\.


--
-- Data for Name: hostel_complaints; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.hostel_complaints (id, resident_id, hostel_id, complaint_type, description, priority, status, assigned_to, resolved_date, remarks, created_at, updated_at) FROM stdin;
7	11	5	Cleanliness Problem	Bathroom needs thorough cleaning	medium	in_progress	\N	\N	\N	2025-11-30 16:15:57.128681	2025-11-30 16:15:57.128681
8	12	4	Noise Complaint	Excessive noise from adjacent rooms after 11 PM	low	resolved	\N	\N	\N	2025-11-30 16:15:57.551965	2025-11-30 16:15:57.551965
10	14	1	Safety Concern	Broken window latch poses safety risk	medium	in_progress	\N	\N	\N	2025-11-30 16:15:58.401323	2025-11-30 16:15:58.401323
9	13	2	Utilities Issue	Water shortage in hostel block B	high	in_progress	53	\N	\N	2025-11-30 16:15:57.977041	2025-11-30 16:21:12.028533
6	10	3	Maintenance Issue	Ceiling fan not working in room 201	high	in_progress	53	\N	\N	2025-11-30 16:15:56.702152	2025-11-30 16:21:35.582916
11	19	7	Safety Concern	lilili	medium	pending	\N	\N	llililioiyo	2025-11-30 16:28:30.045998	2025-11-30 16:28:30.045998
\.


--
-- Data for Name: hostel_residents; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.hostel_residents (id, student_id, hostel_id, room_id, admission_date, checkout_date, guardian_contact, emergency_contact, status, created_at, updated_at) FROM stdin;
10	23	1	1	2025-08-02	\N	\N	\N	active	2025-11-30 15:43:23.130279	2025-11-30 15:43:23.130279
11	25	1	2	2025-08-22	\N	\N	\N	active	2025-11-30 15:43:23.130279	2025-11-30 15:43:23.130279
12	26	2	6	2025-07-03	\N	\N	\N	active	2025-11-30 15:43:23.130279	2025-11-30 15:43:23.130279
13	28	2	7	2025-09-01	\N	\N	\N	active	2025-11-30 15:43:23.130279	2025-11-30 15:43:23.130279
14	30	3	11	2025-09-11	\N	\N	\N	active	2025-11-30 15:43:23.130279	2025-11-30 15:43:23.130279
15	22	4	16	2025-10-01	\N	\N	\N	active	2025-11-30 15:43:23.130279	2025-11-30 15:43:23.130279
17	29	1	3	2025-10-31	\N	\N	\N	active	2025-11-30 15:43:23.130279	2025-11-30 15:43:23.130279
18	31	2	8	2025-11-10	\N	\N	\N	active	2025-11-30 15:43:23.130279	2025-11-30 15:43:23.130279
19	39	5	25	2025-11-27	2025-11-26	9897908998	76587967579	active	2025-11-30 15:56:19.727231	2025-11-30 15:56:19.727231
\.


--
-- Data for Name: hostel_rooms; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.hostel_rooms (id, hostel_id, room_number, room_type, capacity, occupied_beds, floor_number, room_fee, amenities, status, created_at, updated_at) FROM stdin;
1	1	A-101	single	1	0	1	5000.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
2	1	A-102	double	2	0	1	8000.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
3	1	A-201	double	2	0	2	8000.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
4	1	A-202	triple	3	0	2	12000.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
5	1	A-301	triple	3	0	3	12000.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
6	2	B-101	single	1	0	1	5500.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
7	2	B-102	double	2	0	1	8500.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
8	2	B-201	double	2	0	2	8500.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
9	2	B-202	triple	3	0	2	13000.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
10	2	B-301	quad	4	0	3	16000.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
11	3	C-101	double	2	0	1	7500.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
12	3	C-102	triple	3	0	1	11000.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
13	3	C-201	triple	3	0	2	11000.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
14	3	C-202	quad	4	0	2	15000.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
15	3	C-301	single	1	0	3	4500.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
16	4	D-101	double	2	0	1	8500.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
17	4	D-102	triple	3	0	1	13000.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
18	4	D-201	quad	4	0	2	16000.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
19	4	D-202	double	2	0	2	8500.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
20	4	D-301	triple	3	0	3	13000.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
22	5	E-102	double	2	0	1	7500.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
23	5	E-201	double	2	0	2	7500.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
26	5	E-302	triple	3	0	3	11000.00	\N	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
25	5	E-301	quad	4	1	3	14000.00	\N	available	2025-11-30 15:27:16.196445	2025-11-30 15:56:20.57823
21	5	E-101	single	1	0	1	4500.00	\N	available	2025-11-30 15:27:16.196445	2025-11-30 15:56:42.082016
\.


--
-- Data for Name: hostel_visitors; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.hostel_visitors (id, resident_id, visitor_name, visitor_phone, visitor_id_proof, visit_date, entry_time, exit_time, purpose, approved_by, created_at, updated_at) FROM stdin;
3	12	Michael Brown	9876543212	ID-01002	2025-11-28	10:00:00	12:30:00	Meeting	\N	2025-11-30 16:03:59.750093	2025-11-30 16:03:59.750093
4	13	Emma Wilson	9876543213	ID-01003	2025-11-27	10:00:00	\N	Holiday	\N	2025-11-30 16:04:00.178477	2025-11-30 16:04:00.178477
5	14	David Lee	9876543214	ID-01004	2025-11-26	10:00:00	12:30:00	Emergency	\N	2025-11-30 16:04:00.607103	2025-11-30 16:04:00.607103
1	10	John Smith	9876543210	ID-01000	2025-11-30	10:00:00	17:30:00	killing a boy	\N	2025-11-30 16:03:58.885136	2025-11-30 16:10:36.885502
\.


--
-- Data for Name: hostels; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.hostels (id, name, hostel_type, address, warden_id, total_rooms, occupied_rooms, status, created_at, updated_at) FROM stdin;
1	Boys Hostel A	boys	123 Main Street, Campus	\N	20	12	active	2025-11-30 15:26:17.859332	2025-11-30 15:26:17.859332
2	Girls Hostel B	girls	456 Campus Road	\N	25	18	active	2025-11-30 15:26:17.859332	2025-11-30 15:26:17.859332
3	Boys Hostel C	boys	789 University Ave	\N	15	10	active	2025-11-30 15:26:17.859332	2025-11-30 15:26:17.859332
4	Girls Hostel D	girls	321 College Lane	\N	20	14	active	2025-11-30 15:26:17.859332	2025-11-30 15:26:17.859332
6	Boys Hostel A	boys	123 Main Street, Campus	\N	20	12	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
7	Girls Hostel B	girls	456 Campus Road	\N	25	18	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
8	Boys Hostel C	boys	789 University Ave	\N	15	10	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
9	Girls Hostel D	girls	321 College Lane	\N	20	14	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
10	Mixed Hostel E	mixed	654 Student Street	\N	30	22	active	2025-11-30 15:27:16.196445	2025-11-30 15:27:16.196445
5	Mixed Hostel E	mixed	654 Student Street	\N	30	0	active	2025-11-30 15:26:17.859332	2025-11-30 15:56:43.353166
\.


--
-- Data for Name: hr_events; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.hr_events (id, title, description, event_date, event_type, location, created_by, created_at, updated_at) FROM stdin;
1	Employee Onboarding	New employee orientation program	2025-12-05	training	HR Office	34	2025-11-30 06:49:15.875259	2025-11-30 06:49:15.875259
2	Team Building Activity	Annual team bonding event	2025-12-15	social	Conference Hall	34	2025-11-30 06:49:15.875259	2025-11-30 06:49:15.875259
3	Performance Review Meeting	Quarterly performance reviews	2025-12-10	meeting	Meeting Room A	34	2025-11-30 06:49:15.875259	2025-11-30 06:49:15.875259
5	HR Policy Update Session	Update on new HR policies	2025-12-08	meeting	Virtual	34	2025-11-30 06:49:15.875259	2025-11-30 06:49:15.875259
6	lilk	liuyiup09p	2025-11-21	training	Auditorium	1	2025-11-30 06:50:33.960585	2025-11-30 06:50:33.960585
\.


--
-- Data for Name: integrations; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.integrations (id, name, integration_type, api_key, api_secret, endpoint_url, configuration, is_active, last_sync, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: inventory_items; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.inventory_items (id, item_code, name, category, description, unit, quantity, reorder_level, unit_price, location, status, created_at, updated_at) FROM stdin;
2	STK-002	Whiteboard Marker (Blue)	Office Supplies	Non-toxic whiteboard markers, blue ink	piece	200	50	25.00	Store Room A	in_stock	2025-12-01 03:43:59.448973	2025-12-01 03:43:59.448973
3	STK-003	Student Notebook (200 pages)	Stationery	Ruled notebook for students, 200 pages	piece	500	100	45.00	Store Room B	in_stock	2025-12-01 03:43:59.448973	2025-12-01 03:43:59.448973
4	STK-004	Chemistry Lab Gloves	Lab Supplies	Latex gloves for chemistry experiments, box of 100	box	25	10	650.00	Science Lab	in_stock	2025-12-01 03:43:59.448973	2025-12-01 03:43:59.448973
5	STK-005	Chalk Box (100 pieces)	Teaching Supplies	White dustless chalk, 100 pieces per box	box	30	20	120.00	Store Room A	in_stock	2025-12-01 03:43:59.448973	2025-12-01 03:43:59.448973
6	STK-006	First Aid Bandages	Medical Supplies	Adhesive bandages, assorted sizes	pack	15	10	180.00	Medical Room	low_stock	2025-12-01 03:43:59.448973	2025-12-01 03:43:59.448973
7	STK-007	USB Flash Drive 32GB	Electronics	USB 3.0 flash drives for data storage	piece	8	20	450.00	IT Store	low_stock	2025-12-01 03:43:59.448973	2025-12-01 03:43:59.448973
\.


--
-- Data for Name: invoices; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.invoices (id, invoice_number, student_id, fee_structure_id, amount, discount, tax, total_amount, amount_paid, balance, due_date, payment_status, payment_method, transaction_id, payment_date, remarks, created_by, created_at, updated_at) FROM stdin;
1	INV202551752	23	2	500.00	200.00	20.00	320.00	320.00	0.00	2025-12-30	paid	cash	no	2025-11-30	\N	1	2025-11-30 02:41:59	2025-11-30 03:23:03.881593
3	INV-001	23	\N	15000.00	0.00	2700.00	17700.00	0.00	0.00	\N	unpaid	\N	\N	\N	\N	\N	2025-12-01 06:29:19.990032	2025-12-01 06:29:19.990032
4	INV-002	25	\N	15000.00	500.00	2610.00	17110.00	0.00	5000.00	\N	unpaid	\N	\N	\N	\N	\N	2025-12-01 06:29:19.990032	2025-12-01 06:29:19.990032
5	INV-003	26	\N	15000.00	0.00	2700.00	17700.00	0.00	0.00	\N	unpaid	\N	\N	\N	\N	\N	2025-12-01 06:29:19.990032	2025-12-01 06:29:19.990032
6	INV-004	28	\N	15000.00	1500.00	2430.00	15930.00	0.00	2000.00	\N	unpaid	\N	\N	\N	\N	\N	2025-12-01 06:29:19.990032	2025-12-01 06:29:19.990032
7	INV-005	30	\N	15000.00	0.00	2700.00	17700.00	0.00	0.00	\N	unpaid	\N	\N	\N	\N	\N	2025-12-01 06:29:19.990032	2025-12-01 06:29:19.990032
8	INV-006	23	\N	15000.00	0.00	2700.00	17700.00	0.00	0.00	\N	unpaid	\N	\N	\N	\N	\N	2025-12-01 06:29:19.990032	2025-12-01 06:29:19.990032
9	INV-007	25	\N	15000.00	750.00	2565.00	17315.00	0.00	3000.00	\N	unpaid	\N	\N	\N	\N	\N	2025-12-01 06:29:19.990032	2025-12-01 06:29:19.990032
10	INV-008	26	\N	15000.00	0.00	2700.00	17700.00	0.00	0.00	\N	unpaid	\N	\N	\N	\N	\N	2025-12-01 06:29:19.990032	2025-12-01 06:29:19.990032
11	INV-009	28	\N	15000.00	2000.00	2340.00	15340.00	0.00	1500.00	\N	unpaid	\N	\N	\N	\N	\N	2025-12-01 06:29:19.990032	2025-12-01 06:29:19.990032
12	INV-010	30	\N	15000.00	0.00	2700.00	17700.00	0.00	0.00	\N	unpaid	\N	\N	\N	\N	\N	2025-12-01 06:29:19.990032	2025-12-01 06:29:19.990032
\.


--
-- Data for Name: leave_applications; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.leave_applications (id, application_number, user_id, leave_type_id, start_date, end_date, total_days, reason, status, applied_date, reviewed_by, reviewed_date, remarks, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: leave_balances; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.leave_balances (id, user_id, leave_type_id, year, total_days, used_days, remaining_days, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: leave_types; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.leave_types (id, name, code, days_allowed, applicable_to, requires_approval, description, status, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: leaves; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.leaves (id, user_id, leave_type, start_date, end_date, reason, status, approved_by, remarks, created_at, updated_at) FROM stdin;
2	1	earned	2025-11-21	2025-11-23	;ou;o	rejected	1	iioio	2025-11-29 08:06:32	2025-11-29 08:13:13
\.


--
-- Data for Name: lesson_plans; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.lesson_plans (id, subject_id, class_id, topic, lesson_date, duration, period_number, learning_outcomes, introduction, content, activities, conclusion, assessment_method, resources, homework, remarks, status, difficulty_level, created_at, updated_at) FROM stdin;
1	\N	\N	l	2025-11-21	77	\N	l	l	jkl	ouo	kjl	li	klji	kl	kj	active	medium	2025-11-29 07:17:18	\N
\.


--
-- Data for Name: library_members; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.library_members (id, user_id, member_number, membership_type, join_date, expiry_date, max_books, status, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: marks; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.marks (id, student_id, exam_id, subject_id, marks_obtained, total_marks, grade, remarks, entered_by, created_at, updated_at) FROM stdin;
6	31	3	43	55.00	100.00	C		1	2025-11-30 02:01:35	2025-11-30 02:01:35
7	31	3	44	23.00	100.00	F		1	2025-11-30 02:01:36	2025-11-30 02:01:36
8	31	3	45	77.00	100.00	B+		1	2025-11-30 02:01:37	2025-11-30 02:01:37
9	31	3	47	88.00	100.00	A		1	2025-11-30 02:01:38	2025-11-30 02:01:38
10	31	3	48	66.00	100.00	B		1	2025-11-30 02:01:39	2025-11-30 02:01:39
1	22	3	43	75.00	100.00	B+		1	2025-11-30 02:00:32	2025-11-30 02:05:29.392191
2	22	3	44	89.00	100.00	A		1	2025-11-30 02:00:33	2025-11-30 02:05:30.250298
3	22	3	45	22.00	100.00	F		1	2025-11-30 02:00:34	2025-11-30 02:05:31.105345
4	22	3	47	77.00	100.00	B+		1	2025-11-30 02:00:35	2025-11-30 02:05:31.960769
5	22	3	48	33.00	100.00	F		1	2025-11-30 02:00:36	2025-11-30 02:05:32.815735
11	23	3	43	88.00	100.00	A		1	2025-11-30 02:15:49	2025-11-30 02:15:49
12	23	3	44	12.00	100.00	F		1	2025-11-30 02:15:50	2025-11-30 02:15:50
13	23	3	45	3.00	100.00	F		1	2025-11-30 02:15:51	2025-11-30 02:15:51
14	23	3	47	66.00	100.00	B		1	2025-11-30 02:15:52	2025-11-30 02:15:52
15	23	3	48	87.00	100.00	A		1	2025-11-30 02:15:53	2025-11-30 02:15:53
\.


--
-- Data for Name: materials; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.materials (id, title, description, file_path, file_type, file_size, subject_id, class_id, uploaded_by, downloads, type, status, created_at, updated_at) FROM stdin;
1	m1		/uploads/materials/692a9306c8da2_1764397830.docx	application/vnd.openxmlformats-officedocument.wordprocessingml.document	16300	44	30	1	1	notes	active	2025-11-29 06:30:30	2025-11-29 06:33:24.24958
\.


--
-- Data for Name: mess_menu; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.mess_menu (id, hostel_id, day_of_week, meal_type, menu_items, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: messages; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.messages (id, sender_id, receiver_id, subject, message_body, is_read, read_at, attachment_path, parent_message_id, created_at, updated_at) FROM stdin;
11	34	53	Welcome to SCIMS	Welcome! You have been registered as an Administrator in the School Management System. Please review the system features and update your profile information.	t	\N	\N	\N	2025-11-26 05:52:55.068868	2025-12-01 05:52:55.068868
14	45	53	Attendance Report - December	Please find the monthly attendance report attached. The overall attendance rate is 94%.	f	\N	\N	\N	2025-11-29 05:52:55.068868	2025-12-01 05:52:55.068868
15	53	35	New Course Created	A new course "Advanced Mathematics" has been added to the system. You can now enroll students.	t	\N	\N	\N	2025-11-29 05:52:55.068868	2025-12-01 05:52:55.068868
16	46	53	Fee Payment Reminder	This is a reminder that fee payment is due on December 20, 2025. Please clear outstanding balances.	f	\N	\N	\N	2025-11-30 05:52:55.068868	2025-12-01 05:52:55.068868
17	53	36	Exam Schedule Finalized	The exam schedule for this semester has been finalized. Mid-terms will start on January 10, 2026.	f	\N	\N	\N	2025-12-01 05:52:55.068868	2025-12-01 05:52:55.068868
18	37	53	Library Book Donation	The library has received 50 new books. The collection has been updated in the system.	t	\N	\N	\N	2025-11-30 23:52:55.068868	2025-12-01 05:52:55.068868
19	53	45	Staff Leave Request Approved	Your leave request for December 25-26 has been approved. Please ensure proper coverage.	f	\N	\N	\N	2025-12-01 02:52:55.068868	2025-12-01 05:52:55.068868
20	38	53	Transport Route Update	Route 3 has been updated with new pickup points. Please inform students about the changes.	f	\N	\N	\N	2025-12-01 04:52:55.068868	2025-12-01 05:58:36
21	53	38	Re: Transport Route Update	ok	f	\N	\N	20	2025-12-01 05:58:51	2025-12-01 05:58:51
\.


--
-- Data for Name: notifications; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.notifications (id, user_id, title, message, type, link, is_read, read_at, created_at, updated_at) FROM stdin;
1	1	Welcome to SCIMS	Welcome to School/College Management System. This is your first notification.	info	/dashboard	f	\N	2025-11-26 05:07:07.549923	2025-11-26 05:07:07.549923
3	1	Fee Payment Due	Your fee payment is due on 2025-12-15. Please pay before the deadline.	warning	/finance/fees	f	\N	2025-11-29 05:07:07.549923	2025-11-29 05:07:07.549923
4	1	Assignment Submitted	Your assignment has been successfully submitted to the class.	success	/academics/assignments	t	\N	2025-11-30 05:07:07.549923	2025-11-30 05:07:07.549923
5	1	New Course Material Available	New study materials have been uploaded for your course. Check them out!	info	/lms/materials	f	\N	2025-12-01 05:07:07.549923	2025-12-01 05:07:07.549923
6	1	Grade Published	Your grades for Midterm Exam have been published. Check your results.	success	/academics/marks	f	\N	2025-12-01 01:07:07.549923	2025-12-01 01:07:07.549923
7	1	Holiday Announcement	The institute will be closed on 2025-12-25 for Winter Break.	info	/calendar/holidays	f	\N	2025-12-01 03:07:07.549923	2025-12-01 03:07:07.549923
8	1	System Maintenance	The system will be under maintenance on 2025-12-10 from 2 AM to 4 AM.	warning	/dashboard	f	\N	2025-12-01 04:07:07.549923	2025-12-01 04:07:07.549923
9	1	New Quiz Available	A new quiz has been created for your class. Attempt it before the deadline.	info	/academics/quizzes	f	\N	2025-12-01 04:37:07.549923	2025-12-01 04:37:07.549923
10	1	Transport Schedule Updated	The transport schedule has been updated. Check your route details.	info	/transport/assignments	f	\N	2025-12-01 04:52:07.549923	2025-12-01 04:52:07.549923
2	1	Attendance Alert	Your attendance is below 75%. Please maintain proper attendance.	warning	/academics/attendance	t	2025-12-01 05:08:01.155676	2025-11-28 05:07:07.549923	2025-12-01 05:08:01.155676
12	1	Bug Fixed	All CRUD operations are working perfectly	success	\N	f	\N	2025-12-01 05:09:53.647227	2025-12-01 05:09:53.647227
15	53	Monthly Finance Report Ready	The monthly financial summary report for November is ready for download.	success	/finance/reports	t	\N	2025-11-27 05:11:07.284366	2025-11-27 05:11:07.284366
18	53	System Backup Completed	Daily system backup completed successfully at 2:00 AM.	success	/dashboard	t	\N	2025-11-30 05:11:07.284366	2025-11-30 05:11:07.284366
13	53	Welcome to SCIMS Admin Panel	Welcome to the School/College Management System. You are logged in as administrator.	info	/dashboard	t	2025-12-01 05:28:40	2025-11-24 05:11:07.284366	2025-12-01 05:28:40.741817
14	53	New Student Admission Pending	There are 5 pending admission applications awaiting your review.	warning	/admissions	t	2025-12-01 05:28:40	2025-11-26 05:11:07.284366	2025-12-01 05:28:40.741817
16	53	Staff Leave Application	Teacher John Doe has submitted a leave application for next week.	info	/hr/leaves	t	2025-12-01 05:28:40	2025-11-28 05:11:07.284366	2025-12-01 05:28:40.741817
17	53	Inventory Stock Alert	Lab equipment stock is running low. Please reorder soon to avoid shortages.	warning	/inventory/stock	t	2025-12-01 05:28:40	2025-11-29 05:11:07.284366	2025-12-01 05:28:40.741817
19	53	Hostel Complaint Received	A new complaint has been filed regarding hostel maintenance issues.	warning	/hostel/complaints	t	2025-12-01 05:28:40	2025-11-30 17:11:07.284366	2025-12-01 05:28:40.741817
20	53	Transport Schedule Conflict	Route 5 has a scheduling conflict that needs to be resolved.	warning	/transport/routes	t	2025-12-01 05:28:40	2025-11-30 23:11:07.284366	2025-12-01 05:28:40.741817
21	53	Quiz Results Published	Quiz results for all classes have been compiled and published.	success	/academics/quizzes	t	2025-12-01 05:28:40	2025-12-01 02:11:07.284366	2025-12-01 05:28:40.741817
22	53	Database Maintenance Required	Schedule database optimization and cleanup for better performance.	info	/dashboard	t	2025-12-01 05:28:40	2025-12-01 04:41:07.284366	2025-12-01 05:28:40.741817
23	53	New Purchase Order Approved	Your purchase order for classroom furniture has been approved by finance.	success	/inventory/purchase-orders	t	2025-12-01 05:28:40	2025-12-01 05:11:07.284366	2025-12-01 05:28:40.741817
\.


--
-- Data for Name: otp_resets; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.otp_resets (id, email, otp, expires_at, is_used, used_at, created_at) FROM stdin;
\.


--
-- Data for Name: payroll; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.payroll (id, payroll_number, staff_id, month, year, basic_salary, allowances, deductions, gross_salary, net_salary, payment_date, payment_method, status, remarks, created_by, created_at, updated_at) FROM stdin;
10	PAY-202411-0005	15	November	2024	48000.00	4500.00	3200.00	52500.00	49300.00	2024-11-30	Bank Transfer	pending	Pending approval	1	2025-11-30 03:42:59.038223	2025-11-30 03:42:59.038223
\.


--
-- Data for Name: purchase_order_items; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.purchase_order_items (id, po_id, item_id, quantity, unit_price, total_price, received_quantity, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: purchase_orders; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.purchase_orders (id, po_number, supplier_id, order_date, expected_delivery, actual_delivery, total_amount, status, created_by, approved_by, remarks, created_at, updated_at) FROM stdin;
2	PO-202411-0002	2	2024-11-20	2024-12-05	\N	150000.00	approved	1	\N	New computer lab equipment	2025-12-01 03:44:24.806799	2025-12-01 03:44:24.806799
3	PO-202411-0003	4	2024-11-22	2024-12-10	\N	35000.00	approved	1	53	Chemistry lab supplies replenishment	2025-12-01 03:44:24.806799	2025-12-01 04:21:30.102196
4	PO-202412-0001	3	2024-12-01	2024-12-20	\N	85000.00	cancelled	1	53	New furniture for classrooms	2025-12-01 03:44:24.806799	2025-12-01 05:03:17.462787
\.


--
-- Data for Name: question_bank; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.question_bank (id, subject_id, class_id, question_text, question_type, difficulty_level, marks, option_a, option_b, option_c, option_d, correct_answer, explanation, chapter_topic, keywords, status, created_at, updated_at) FROM stdin;
2	43	27	What is the atomic number of Carbon?	multiple_choice	easy	1	4	6	8	12	B	Carbon has 6 protons in its nucleus	Atomic Structure	carbon, atomic number, nucleus	active	2025-11-30 06:18:04.8315	\N
3	43	27	Which of the following is a covalent bond?	multiple_choice	medium	2	NaCl	H2O	KCl	MgO	B	H2O is formed by covalent bonding between hydrogen and oxygen	Chemical Bonding	covalent, ionic, bond type	active	2025-11-30 06:18:04.8315	\N
4	43	27	What is the pH of a neutral solution?	multiple_choice	easy	1	0	7	14	3.5	B	Neutral solutions have a pH of 7	Acids and Bases	pH, neutral, acidic, basic	active	2025-11-30 06:18:04.8315	\N
5	44	30	What is the powerhouse of the cell?	multiple_choice	easy	1	Nucleus	Mitochondria	Ribosome	Endoplasmic Reticulum	B	Mitochondria produces ATP, the energy currency of cells	Cell Structure	mitochondria, energy, ATP	active	2025-11-30 06:18:04.8315	\N
6	44	30	How many chromosomes do humans have?	multiple_choice	easy	1	23	46	92	48	B	Humans have 46 chromosomes (23 pairs)	Genetics	chromosomes, human, genetics	active	2025-11-30 06:18:04.8315	\N
7	44	30	Which organelle is responsible for protein synthesis?	multiple_choice	medium	2	Golgi apparatus	Ribosome	Lysosome	Peroxisome	B	Ribosomes are the sites of protein synthesis	Cell Structure	ribosome, protein, synthesis	active	2025-11-30 06:18:04.8315	\N
8	45	29	Who wrote "Hamlet"?	multiple_choice	easy	1	Oscar Wilde	William Shakespeare	Jane Austen	Mark Twain	B	William Shakespeare wrote Hamlet in the early 1600s	Shakespeare Works	hamlet, shakespeare, drama	active	2025-11-30 06:18:04.8315	\N
9	45	29	What literary device is used in "the wind whispered softly"?	multiple_choice	medium	2	Metaphor	Personification	Simile	Oxymoron	B	Personification gives human qualities to non-human things	Literary Devices	personification, wind, whispered	active	2025-11-30 06:18:04.8315	\N
10	47	31	What is the capital of France?	multiple_choice	easy	1	Lyon	Paris	Marseille	Toulouse	B	Paris is the capital and largest city of France	World Capitals	france, capital, paris	active	2025-11-30 06:18:04.8315	\N
11	47	31	Which is the largest continent by area?	multiple_choice	easy	1	Africa	Europe	Asia	Antarctica	C	Asia is the largest continent covering about 44.5 million km²	Continents	asia, continent, area	active	2025-11-30 06:18:04.8315	\N
12	48	27	What does HTML stand for?	multiple_choice	easy	1	Hyper Text Markup Language	High Tech Modern Language	Home Tool Markup Language	Hyperlinks and Text Markup Language	A	HTML is the standard markup language for web pages	Web Development	html, markup, web	active	2025-11-30 06:18:04.8315	\N
13	48	27	Which of the following is a programming language?	multiple_choice	easy	1	HTML	CSS	Python	XML	C	Python is a general-purpose programming language	Programming Languages	python, language, programming	active	2025-11-30 06:18:04.8315	\N
\.


--
-- Data for Name: quiz_attempts; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.quiz_attempts (id, quiz_id, student_id, start_time, end_time, marks_obtained, total_marks, percentage, status, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: quiz_questions; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.quiz_questions (id, quiz_id, question_id, question_order, marks, created_at) FROM stdin;
1	1	2	1	1	2025-11-30 06:22:09.071784
2	1	3	2	1	2025-11-30 06:22:09.920181
3	1	4	3	1	2025-11-30 06:22:10.764832
\.


--
-- Data for Name: quizzes; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.quizzes (id, title, subject_id, class_id, teacher_id, description, duration_minutes, total_marks, passing_marks, start_time, end_time, status, created_at, updated_at) FROM stdin;
1	Chapter 3: Quadratic Equations	43	27	1	Test your knowledge on solving quadratic equations and their applications	45	50	25	2025-11-30 06:12:35.932775	2025-12-07 06:12:35.932775	active	2025-11-30 06:12:35.932775	2025-11-30 06:12:35.932775
2	Biology: Cell Structure Quiz	44	30	1	Assessment on cell biology including structure and function of organelles	30	40	20	2025-11-29 06:12:35.932775	2025-12-05 06:12:35.932775	active	2025-11-30 06:12:35.932775	2025-11-30 06:12:35.932775
4	Geography: World Capitals	47	31	1	Test your knowledge of world capitals and geographical locations	20	25	12	2025-11-30 06:12:35.932775	2025-12-03 06:12:35.932775	active	2025-11-30 06:12:35.932775	2025-11-30 06:12:35.932775
5	Computer Science: Programming Basics	48	27	1	Introduction to programming concepts and syntax	50	50	25	2025-11-27 06:12:35.932775	2025-12-08 06:12:35.932775	closed	2025-11-30 06:12:35.932775	2025-11-30 06:12:35.932775
3	English Literature: Shakespeare	45	29	1	Quiz on Shakespeare's works and literary devices	40	35	18	2025-11-28 06:12:00	2025-12-10 06:12:00	active	2025-11-30 06:12:35.932775	2025-11-30 06:25:44.756939
\.


--
-- Data for Name: recruitment_positions; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.recruitment_positions (id, title, department, description, requirements, number_of_positions, status, created_by, created_at, updated_at) FROM stdin;
2	Accountant	Finance	Manage school financial records and reporting	B.Com, CPA certification, 3+ years experience	1	open	34	2025-11-30 06:51:55.704056	2025-11-30 06:51:55.704056
3	HR Manager	Human Resources	Handle recruitment, payroll, and employee relations	MBA/PGDM, 4+ years HR experience	1	open	34	2025-11-30 06:51:55.704056	2025-11-30 06:51:55.704056
4	Lab Technician	Science	Manage science laboratory and equipment	Diploma in Lab Science, 2+ years experience	2	open	34	2025-11-30 06:51:55.704056	2025-11-30 06:51:55.704056
5	Administrative Assistant	Administration	Support administrative operations and documentation	HSC, Computer literacy, 1+ year experience	1	closed	34	2025-11-30 06:51:55.704056	2025-11-30 06:51:55.704056
6	don	Academic	erwrwrwe	werwerwer	1	open	1	2025-11-30 06:53:19.326119	2025-11-30 06:53:19.326119
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.roles (id, name, display_name, description, created_at, updated_at) FROM stdin;
1	admin	Administrator	Full system access and management	2025-11-26 05:00:22.418423	2025-11-26 05:00:22.418423
2	teacher	Teacher	Manage classes, attendance, exams and marks	2025-11-26 05:00:22.418423	2025-11-26 05:00:22.418423
3	student	Student	Access learning materials and view results	2025-11-26 05:00:22.418423	2025-11-26 05:00:22.418423
4	parent	Parent	Monitor student progress and attendance	2025-11-26 05:00:22.418423	2025-11-26 05:00:22.418423
5	accountant	Accountant	Manage fees and financial records	2025-11-26 05:00:22.418423	2025-11-26 05:00:22.418423
6	hr	HR Manager	Manage staff and admissions	2025-11-26 05:00:22.418423	2025-11-26 05:00:22.418423
50	Admin	Admin	Admin role	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
51	Teacher	Teacher	Teacher role	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
52	Student	Student	Student role	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
53	Parent	Parent	Parent role	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
54	Accountant	Accountant	Accountant role	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
55	Librarian	Librarian	Librarian role	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
59	rana22	RANA2	ddddddddd	2025-12-01 08:36:17.599356	2025-12-01 08:36:17.599356
\.


--
-- Data for Name: route_stops; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.route_stops (id, route_id, stop_name, stop_order, pickup_time, drop_time, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: routes; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.routes (id, route_name, route_number, start_point, end_point, distance, fare, vehicle_id, driver_id, status, created_at, updated_at) FROM stdin;
7	Suburb Express	RT-002	Central Hub	North Suburb	22.30	75.00	\N	\N	active	2025-11-30 07:12:43.577828	2025-11-30 07:12:43.577828
8	Airport Shuttle	RT-003	Downtown	Airport Terminal	35.80	150.00	\N	\N	active	2025-11-30 07:12:43.577828	2025-11-30 07:12:43.577828
9	Local Feeder Route	RT-004	Market Square	Bus Depot	8.20	30.00	\N	\N	active	2025-11-30 07:12:43.577828	2025-11-30 07:12:43.577828
10	Industrial Zone	RT-005	City Center	Industrial Estate	18.50	60.00	\N	\N	active	2025-11-30 07:12:43.577828	2025-11-30 07:12:43.577828
11	Main City Route	RT-001	City Center	Railway Station	76.00	65.00	3	55	active	2025-11-30 07:46:25.318845	2025-11-30 07:46:25.318845
13	Main City Routeeee	RT-001ee	City Centeree	eeee	55.00	33.00	3	63	active	2025-11-30 08:19:07.718868	2025-11-30 08:19:07.718868
\.


--
-- Data for Name: sms_logs; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.sms_logs (id, recipient_phone, recipient_name, message_content, sent_by, sent_at, status, error_message, provider, cost, created_at) FROM stdin;
\.


--
-- Data for Name: staff; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.staff (id, user_id, employee_id, designation, department, qualification, experience_years, joining_date, salary, bank_name, account_number, emergency_contact, documents, status, created_at, updated_at, department_id) FROM stdin;
16	73	EMP20259134	hr		jjjjjjjj	44	2025-12-01	60000.00	jjjjjjjjjjjjjjjjjjjjjjjjjj	888888888jiu9999	76587967579	\N	active	2025-12-01 08:28:08	2025-12-01 08:29:56.400971	\N
15	48	EMP20240005	Liberairan			\N	2024-01-01	\N				\N	active	2025-11-26 05:07:16.955887	2025-12-01 08:31:01.084404	\N
\.


--
-- Data for Name: students; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.students (id, user_id, admission_number, class_id, roll_number, admission_date, guardian_name, guardian_phone, guardian_email, guardian_relation, previous_school, blood_group, medical_conditions, documents, status, created_at, updated_at) FROM stdin;
23	35	STU20240002	29	2	2024-01-15	\N	\N	\N	\N	\N	\N	\N	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
25	37	STU20240004	31	4	2024-01-15	\N	\N	\N	\N	\N	\N	\N	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
26	38	STU20240005	27	5	2024-01-15	\N	\N	\N	\N	\N	\N	\N	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
28	40	STU20240007	29	7	2024-01-15	\N	\N	\N	\N	\N	\N	\N	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
30	42	STU20240009	31	9	2024-01-15	\N	\N	\N	\N	\N	\N	\N	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
22	34	STU20240001	\N	1	2024-01-15	\N	\N	\N	\N	\N	\N	\N	\N	active	2025-11-26 05:07:16.955887	2025-11-29 04:37:41.049963
27	39	STU20240006	\N	6	2024-01-15	\N	\N	\N	\N	\N	\N	\N	\N	active	2025-11-26 05:07:16.955887	2025-11-29 04:37:41.049963
29	41	STU20240008	31	8	2024-01-15				\N	\N	B-	\N	\N	active	2025-11-26 05:07:16.955887	2025-11-30 11:24:36.079686
31	43	STU20240010	27	10	2024-01-15				\N	\N		\N	\N	inactive	2025-11-26 05:07:16.955887	2025-11-30 11:25:32.571694
38	65	EXT-65	30	EXT-65	2025-11-30	\N	\N	\N	\N	\N	\N	\N	\N	active	2025-11-30 15:49:01.120546	2025-11-30 15:49:01.120546
39	66	EXT-66	30	EXT-66	2025-11-30				\N	\N		\N	\N	active	2025-11-30 15:49:01.120546	2025-12-01 07:47:29.571178
44	72	ADM202546710	27	ROLL5	2025-12-23	ffffffff	1234567890	gaudianemail@gmail.com	\N	\N	AB-	\N	\N	active	2025-12-01 07:49:14	2025-12-01 07:49:14
\.


--
-- Data for Name: subjects; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.subjects (id, name, code, course_id, teacher_id, class_id, credits, type, description, status, created_at, updated_at) FROM stdin;
43	Chemistry	CHE	31	\N	\N	3	theory	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
44	Biology	BIO	31	\N	\N	3	theory	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
45	English	ENG	31	\N	\N	3	theory	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
47	Geography	GEO	31	\N	\N	3	theory	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
48	Computer Science	COM	31	\N	\N	3	theory	\N	active	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
\.


--
-- Data for Name: suppliers; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.suppliers (id, supplier_code, name, contact_person, email, phone, address, city, country, payment_terms, status, created_at, updated_at) FROM stdin;
2	SUP-002	Tech Solutions Ltd	Priya Patel	priya@techsolutions.com	+91 9876543211	456 Tech Park, Phase 2	Bangalore	India	Net 15 days	active	2025-12-01 03:43:37.939707	2025-12-01 03:43:37.939707
3	SUP-003	Furniture World	Amit Singh	amit@furnitureworld.com	+91 9876543212	789 Furniture Market	Delhi	India	50% Advance	active	2025-12-01 03:43:37.939707	2025-12-01 03:43:37.939707
4	SUP-004	Science Lab Equipments	Dr. Neha Gupta	neha@scilabequip.com	+91 9876543213	321 Science Hub	Chennai	India	Net 45 days	active	2025-12-01 03:43:37.939707	2025-12-01 03:43:37.939707
5	SUP-005	Sports Gear India	Vikram Reddy	vikram@sportsgear.com	+91 9876543214	654 Sports Complex Road	Hyderabad	India	Net 30 days	active	2025-12-01 03:43:37.939707	2025-12-01 03:43:37.939707
\.


--
-- Data for Name: support_messages; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.support_messages (id, user_id, subject, message, status, admin_reply, admin_replied_by, replied_at, created_at, updated_at) FROM stdin;
11	34	Issue with Fee Payment Gateway	I am unable to pay my fees through the online portal. The payment gateway keeps timing out.	replied	The payment gateway has been updated. Please try again now. If the issue persists, contact support.	53	2025-11-30 06:03:33.805601	2025-12-01 06:03:33.805601	2025-12-01 06:03:33.805601
12	35	Missing Exam Schedule	The exam schedule for this semester has not been updated. When will it be published?	replied	Exam schedules will be published by December 15th. Thank you for your patience.	53	2025-11-29 06:03:33.805601	2025-12-01 06:03:33.805601	2025-12-01 06:03:33.805601
13	36	Request for Leave of Absence	I have a family emergency and need to take leave for 2 weeks. Please advise on the process.	open	\N	\N	\N	2025-12-01 06:03:33.805601	2025-12-01 06:03:33.805601
14	37	Doubt in Subject - Mathematics	I am having difficulty understanding the concepts taught in last week's class. Can I get additional study materials?	replied	Additional materials have been uploaded to the LMS. Please refer to the Mathematics folder.	53	2025-11-28 06:03:33.805601	2025-12-01 06:03:33.805601	2025-12-01 06:03:33.805601
15	38	Transport Route Change Request	I have shifted to a new location and need my route changed. My current pickup point is no longer convenient.	open	\N	\N	\N	2025-12-01 06:03:33.805601	2025-12-01 06:03:33.805601
16	39	Hostel Room Assignment Issue	There was an issue with my room assignment. I was assigned to a room that does not match my preferences.	replied	Your room assignment has been updated as per your request. Please check with hostel staff for details.	53	2025-11-30 06:03:33.805601	2025-12-01 06:03:33.805601	2025-12-01 06:03:33.805601
17	40	Teacher Attendance Reporting Problem	I am unable to submit attendance records through the portal. I keep getting an error.	open	\N	\N	\N	2025-12-01 06:03:33.805601	2025-12-01 06:03:33.805601
18	42	Parent Portal Access Issue	I cannot log into the parent portal. My credentials are correct but the system says invalid login.	replied	Your account has been unlocked. Please try logging in again. Contact support if the issue persists.	53	2025-11-30 18:03:33.805601	2025-12-01 06:03:33.805601	2025-12-01 06:03:33.805601
20	45	Certificate Download Issue	I am unable to download my completion certificate from the system.	replied	Your certificate has been regenerated and is ready for download. Please try again.	53	2025-12-01 00:03:33.805601	2025-12-01 06:03:33.805601	2025-12-01 06:03:33.805601
21	50	Re: Transport Route Update	kkkkkkkkkkkkkkkkkkkkkkkkkkkkkk	replied	okjjjjjjjjjjjjjjjjjjj	53	2025-12-01 06:22:47	2025-12-01 06:18:49	2025-12-01 06:22:47
\.


--
-- Data for Name: syllabuses; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.syllabuses (id, subject_id, class_id, academic_year, title, description, topics, learning_objectives, duration_hours, file_path, created_by, status, created_at, updated_at, overview, learning_outcomes, topics_covered, assessment_methods, grading_scale, recommended_resources, prerequisites, duration) FROM stdin;
\.


--
-- Data for Name: system_settings; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.system_settings (id, setting_key, setting_value, setting_type, category, description, is_editable, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: timetables; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.timetables (id, class_id, subject_id, teacher_id, day_of_week, start_time, end_time, room_number, academic_year, semester, status, created_at, updated_at) FROM stdin;
2	27	43	48	saturday	01:29:00	02:29:00	103	2025	1	active	2025-11-29 05:00:05	2025-11-29 05:00:05
5	30	44	46	tuesday	00:38:00	01:38:00	103	2025	2	active	2025-11-29 05:08:51	2025-11-29 05:08:51
6	30	44	46	wednesday	00:38:00	01:38:00	103	2025	2	active	2025-11-29 05:08:52	2025-11-29 05:08:52
7	30	44	46	thursday	00:38:00	01:38:00	103	2025	2	active	2025-11-29 05:08:52	2025-11-29 05:08:52
8	30	44	46	friday	00:38:00	01:38:00	103	2025	2	active	2025-11-29 05:08:53	2025-11-29 05:08:53
9	30	44	46	saturday	00:38:00	01:38:00	103	2025	2	active	2025-11-29 05:08:54	2025-11-29 05:08:54
\.


--
-- Data for Name: transport_assignments; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.transport_assignments (id, student_id, route_id, stop_id, start_date, end_date, status, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: user_roles; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.user_roles (id, user_id, role_id, created_at, updated_at) FROM stdin;
1	1	1	2025-11-26 05:00:44.66978	2025-11-26 05:00:44.66978
2	49	3	2025-11-26 05:11:23.789758	2025-11-26 05:11:23.789758
3	50	3	2025-11-26 05:12:08.191533	2025-11-26 05:12:08.191533
4	51	3	2025-11-26 09:52:42.410669	2025-11-26 09:52:42.410669
7	53	1	2025-11-30 07:18:31.532795	2025-11-30 07:18:31.532795
8	54	3	2025-11-30 07:18:31.532795	2025-11-30 07:18:31.532795
9	55	2	2025-11-30 07:18:31.532795	2025-11-30 07:18:31.532795
10	56	1	2025-11-30 07:18:31.532795	2025-11-30 07:18:31.532795
19	71	3	2025-12-01 07:19:42.788522	2025-12-01 07:19:42.788522
20	72	3	2025-12-01 07:49:12.795885	2025-12-01 07:49:12.795885
23	73	55	2025-12-01 08:29:57.785633	2025-12-01 08:29:57.785633
24	48	55	2025-12-01 08:31:02.383135	2025-12-01 08:31:02.383135
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.users (id, email, phone, password, first_name, last_name, gender, date_of_birth, address, photo, status, email_verified_at, remember_token, created_at, updated_at) FROM stdin;
34	student1@school.com	1234567891	$2y$10$YmCqxT2CKM0OedwSmxmLCeShhGP66BxLD5swqAesH3VZlVVwoa2Su	Student	Number 1	\N	2005-01-01	\N	\N	active	\N	\N	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
35	student2@school.com	1234567892	$2y$10$w3tUnkHkK/rUKn6HYaQI0uB4gGZ6k4hOJ05HnY31JON.0JxwJfxMq	Student	Number 2	\N	2005-01-01	\N	\N	active	\N	\N	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
36	student3@school.com	1234567893	$2y$10$YDd/snGdIdqJVMk5VnWrnee5Ifrlm3.tBsm0iMiPXbeYk4egYVWFi	Student	Number 3	\N	2005-01-01	\N	\N	active	\N	\N	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
37	student4@school.com	1234567894	$2y$10$gffoiUAWCACIDlRp6OG/k.LYJ9MBm/Egj6MgzAWtyhnNiNQECsXHi	Student	Number 4	\N	2005-01-01	\N	\N	active	\N	\N	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
38	student5@school.com	1234567895	$2y$10$/2q8o8lv5zZgSw/5vvU6UOCT93dPgyHat.PDDyfDIG4pDllaRq3s.	Student	Number 5	\N	2005-01-01	\N	\N	active	\N	\N	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
39	student6@school.com	1234567896	$2y$10$PkUNEBnQmHTLYWGGS8ke7Op8xRG6Vnxh8BDOAq0IOe7V.T9yB9O1y	Student	Number 6	\N	2005-01-01	\N	\N	active	\N	\N	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
40	student7@school.com	1234567897	$2y$10$mkQoGFFiQauleVfANhMiVOB9sk/UsQgDHbwWHiLxUovoTUQ35T/wy	Student	Number 7	\N	2005-01-01	\N	\N	active	\N	\N	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
42	student9@school.com	1234567899	$2y$10$BSBCTTqR6zswwX7j52q6d.quLpSnWNVVePI/8et4J6b/rscUxjpS.	Student	Number 9	\N	2005-01-01	\N	\N	active	\N	\N	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
45	teacher2@school.com	9876543212	$2y$10$tOm7rlQNBPdeWKZr5BPW5epxAyc4stax9tuqHX2b5vR6ZReUJ4uhm	Teacher	Number 2	\N	\N	\N	\N	active	\N	\N	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
46	teacher3@school.com	9876543213	$2y$10$BzlK3tQ1Bp9mN2fTiSE3bO8WkWKhcJZAaC3afDV0EghGY/4PswYEu	Teacher	Number 3	\N	\N	\N	\N	active	\N	\N	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
41	student8@school.com	1234567898	$2y$10$Xr3Htulo8.oKdfETA8VqdeDWFqbTPUOIzxeTyrJDEPb9J16XKlh/G	Student	Number 8	female	2005-01-01	\N	\N	active	\N	\N	2025-11-26 05:07:16.955887	2025-11-30 11:24:35.641333
43	student10@school.com	12345678910	$2y$10$gRfRi1SYh7yTHgtKqSjBR.S31gVdODaz/bDYsBRJPWuecSXW7nzU6	Student	Number 10	\N	2005-01-01	\N	\N	active	\N	\N	2025-11-26 05:07:16.955887	2025-11-30 11:25:32.148309
47	teacher4@school.com	9876543214	$2y$10$ciGrfzj8vRD2qGhYFguy9OIgQzgLl8z84KyVi2m6X5QJ1ho/H9Kvm	Teacher	Number 4	\N	\N	\N	\N	active	\N	\N	2025-11-26 05:07:16.955887	2025-11-26 05:07:16.955887
49	user1@gmail.com	1234567890	$2y$10$LTXi0ksx87KAWdCf2J76GeENMfxGep7vUO0UGuSWTqY0vBUQPxc3y	user1	last	\N	\N	\N	\N	active	\N	\N	2025-11-26 05:11:22	2025-11-26 05:11:22
50	user93@user.com	1234567890	$2y$10$BcsRs2.68qMqWYvlCA9tCOLBPbWDkP/vUxuFHVRZPUPI1cqEPtZ/W	user93	last	\N	\N	\N	\N	active	\N	\N	2025-11-26 05:12:06	2025-11-26 05:12:06
1	admin@school.com	1234567890	$2y$10$BrYbkC.Yq32coP/ZY9zKCeEQ9JjOaP8ZFckE580EE606FrEMJurGS	Admin	User	\N	\N	\N	\N	active	\N	\N	2025-11-26 05:00:44.075995	2025-11-26 05:14:54.913825
51	jatinkumarsharma2040@gmail.com	7465066991	$2y$10$uI02sLurgIUDlN4IY2opY.rCbnUL.zIULTTCDH9pIsn6PiAHADUXi	Jatin	Sharma	male	2008-10-14		\N	active	\N	\N	2025-11-26 09:52:42	2025-11-26 09:52:42
53	admin@test.local	\N	$2y$10$UAFM1nM0Equ7CKGr5ppVzu7WTGCMIb9IQcgZZDdoCGCKrnzqBacfW	Admin	User	\N	\N	\N	\N	active	\N	\N	2025-11-30 07:18:31.377935	2025-11-30 07:20:28.606538
54	student@test.local	\N	$2y$10$UAFM1nM0Equ7CKGr5ppVzu7WTGCMIb9IQcgZZDdoCGCKrnzqBacfW	Student	User	\N	\N	\N	\N	active	\N	\N	2025-11-30 07:18:31.377935	2025-11-30 07:20:28.606538
55	teacher@test.local	\N	$2y$10$UAFM1nM0Equ7CKGr5ppVzu7WTGCMIb9IQcgZZDdoCGCKrnzqBacfW	Teacher	User	\N	\N	\N	\N	active	\N	\N	2025-11-30 07:18:31.377935	2025-11-30 07:20:28.606538
56	hr@test.local	\N	$2y$10$UAFM1nM0Equ7CKGr5ppVzu7WTGCMIb9IQcgZZDdoCGCKrnzqBacfW	HR	User	\N	\N	\N	\N	active	\N	\N	2025-11-30 07:18:31.377935	2025-11-30 07:20:28.606538
57	driver@user.com	+911234567890	$2y$10$a.VHyGXyW0W5wmCFPsheouRF.p4Pvi6u77eTNZBaKSsZgu33LNRu6	Rohan	last	\N	\N	\N	\N	active	\N	\N	2025-11-30 07:50:26.300909	2025-11-30 07:50:26.300909
59	rajesh.driver@school.local	98765-43210	$2y$10$N9qo8uLOickgx2ZMRZoMye	Rajesh	Kumar	\N	\N	\N	\N	active	\N	\N	2025-11-30 07:57:33.184798	2025-11-30 07:57:33.184798
60	priya.driver@school.local	98765-43211	$2y$10$N9qo8uLOickgx2ZMRZoMye	Priya	Singh	\N	\N	\N	\N	active	\N	\N	2025-11-30 07:57:33.184798	2025-11-30 07:57:33.184798
62	sneha.driver@school.local	98765-43213	$2y$10$N9qo8uLOickgx2ZMRZoMye	Sneha	Sharma	\N	\N	\N	\N	active	\N	\N	2025-11-30 07:57:33.184798	2025-11-30 07:57:33.184798
63	vikram.driver@school.local	98765-43214	$2y$10$N9qo8uLOickgx2ZMRZoMye	Vikram	Desai	\N	\N	\N	\N	active	\N	\N	2025-11-30 07:57:33.184798	2025-11-30 07:57:33.184798
65	extrastud-a@test.local	\N	$2y$10$LlKJrPQVyG/4jZKh6UzqkOkKJaKCVWxHJfWxGnxEpLKfE3OFuUMkC	Extra	Student A	\N	\N	\N	\N	active	\N	\N	2025-11-30 15:48:28.653703	2025-11-30 15:48:28.653703
67	extrastud-c@test.local	\N	$2y$10$LlKJrPQVyG/4jZKh6UzqkOkKJaKCVWxHJfWxGnxEpLKfE3OFuUMkC	Extra	Student C	\N	\N	\N	\N	active	\N	\N	2025-11-30 15:48:28.653703	2025-11-30 15:48:28.653703
68	extrastud-d@test.local	\N	$2y$10$LlKJrPQVyG/4jZKh6UzqkOkKJaKCVWxHJfWxGnxEpLKfE3OFuUMkC	Extra	Student D	\N	\N	\N	\N	active	\N	\N	2025-11-30 15:48:28.653703	2025-11-30 15:48:28.653703
69	extrastud-e@test.local	\N	$2y$10$LlKJrPQVyG/4jZKh6UzqkOkKJaKCVWxHJfWxGnxEpLKfE3OFuUMkC	Extra	Student E	\N	\N	\N	\N	active	\N	\N	2025-11-30 15:48:28.653703	2025-11-30 15:48:28.653703
71	jatinkumar2040@gmail.com	7465066991	$2y$10$3otO4FF3aBCWf8jXnxN6He9lfx5BILuCPQA9O/iRksi8EExwypr/.	Jatin	sharma	male	2025-11-12	Main Road Jartoli Mod Jattari	\N	active	\N	\N	2025-12-01 07:19:42.788522	2025-12-01 07:19:42.788522
66	extrastud-b@test.local	333333333	$2y$10$LlKJrPQVyG/4jZKh6UzqkOkKJaKCVWxHJfWxGnxEpLKfE3OFuUMkC	Extra	Student B	\N	\N	\N	\N	active	\N	\N	2025-11-30 15:48:28.653703	2025-12-01 07:47:29.14034
72	aaaa@gmail.com	1234567898	$2y$10$YQt29eaNZqk.FVH6.8At0.LKerWUnEdhJk.GjSdbQGSIi.m0fUnG.	Arjun	Brown	female	2025-12-24	fffffffffff	\N	active	\N	\N	2025-12-01 07:49:12	2025-12-01 07:49:12
73	random@gmail.com	9876543215	$2y$10$ABtVG/sAM7lUVI8ZJdCY8.Yo/S2JrKeLD.157rnsBj72EcIiFtC2S	Rohan	Brown	male	2025-12-18	kkkkkkkkkkkkk	\N	active	\N	\N	2025-12-01 08:28:06	2025-12-01 08:29:55.80129
48	teacher5@school.com	9876543215	$2y$10$4nScf9naLJHZiUzNffb50O3h.tyH/n6yO6gm/Pe2ic9wsSYhHlU/C	don	 5	\N	\N		\N	active	\N	\N	2025-11-26 05:07:16.955887	2025-12-01 08:31:00.637833
\.


--
-- Data for Name: vehicle_maintenance; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.vehicle_maintenance (id, vehicle_id, maintenance_type, description, maintenance_date, cost, vendor, next_maintenance_date, status, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: vehicles; Type: TABLE DATA; Schema: public; Owner: neondb_owner
--

COPY public.vehicles (id, vehicle_number, vehicle_type, model, manufacturer, year, capacity, fuel_type, registration_date, insurance_expiry, fitness_expiry, status, created_at, updated_at) FROM stdin;
2	DL01CD5002	Bus	Integral Coach	Ashok Leyland	2021	45	Diesel	2021-08-20	2025-08-20	2025-10-15	active	2025-11-30 07:01:16.12212	2025-11-30 07:01:16.12212
3	DL01EF5003	Van	Tempo Traveller	Force Motors	2023	20	Diesel	2023-03-10	2027-03-10	2026-09-30	active	2025-11-30 07:01:16.12212	2025-11-30 07:01:16.12212
4	DL01GH5004	Minibus	Bolero Pik-Up	Mahindra	2020	15	Diesel	2020-11-05	2024-11-05	2025-05-20	maintenance	2025-11-30 07:01:16.12212	2025-11-30 07:01:16.12212
5	DL01IJ5005	Bus	Super Starbus	Tata Motors	2019	55	Diesel	2019-01-12	2025-01-12	2025-08-10	active	2025-11-30 07:01:16.12212	2025-11-30 07:01:16.12212
\.


--
-- Name: academic_calendar_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.academic_calendar_id_seq', 1, true);


--
-- Name: admissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.admissions_id_seq', 6, true);


--
-- Name: announcements_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.announcements_id_seq', 11, true);


--
-- Name: assets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.assets_id_seq', 10, true);


--
-- Name: assignment_submissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.assignment_submissions_id_seq', 1, false);


--
-- Name: assignments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.assignments_id_seq', 6, true);


--
-- Name: attendance_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.attendance_id_seq', 64, true);


--
-- Name: audit_logs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.audit_logs_id_seq', 1, false);


--
-- Name: book_issues_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.book_issues_id_seq', 1, false);


--
-- Name: books_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.books_id_seq', 5, true);


--
-- Name: budget_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.budget_id_seq', 11, true);


--
-- Name: budgets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.budgets_id_seq', 1, false);


--
-- Name: calendar_events_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.calendar_events_id_seq', 6, true);


--
-- Name: classes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.classes_id_seq', 33, true);


--
-- Name: courses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.courses_id_seq', 40, true);


--
-- Name: database_backups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.database_backups_id_seq', 1, false);


--
-- Name: departments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.departments_id_seq', 2, true);


--
-- Name: email_logs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.email_logs_id_seq', 1, false);


--
-- Name: exams_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.exams_id_seq', 4, true);


--
-- Name: expenses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.expenses_id_seq', 11, true);


--
-- Name: fee_structure_templates_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.fee_structure_templates_id_seq', 1, false);


--
-- Name: fees_structures_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.fees_structures_id_seq', 9, true);


--
-- Name: forum_posts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.forum_posts_id_seq', 1, false);


--
-- Name: forums_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.forums_id_seq', 5, true);


--
-- Name: holidays_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.holidays_id_seq', 6, true);


--
-- Name: hostel_complaints_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.hostel_complaints_id_seq', 11, true);


--
-- Name: hostel_residents_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.hostel_residents_id_seq', 19, true);


--
-- Name: hostel_rooms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.hostel_rooms_id_seq', 26, true);


--
-- Name: hostel_visitors_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.hostel_visitors_id_seq', 6, true);


--
-- Name: hostels_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.hostels_id_seq', 10, true);


--
-- Name: hr_events_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.hr_events_id_seq', 6, true);


--
-- Name: integrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.integrations_id_seq', 1, false);


--
-- Name: inventory_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.inventory_items_id_seq', 8, true);


--
-- Name: invoices_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.invoices_id_seq', 12, true);


--
-- Name: leave_applications_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.leave_applications_id_seq', 1, false);


--
-- Name: leave_balances_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.leave_balances_id_seq', 1, false);


--
-- Name: leave_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.leave_types_id_seq', 1, false);


--
-- Name: leaves_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.leaves_id_seq', 2, true);


--
-- Name: lesson_plans_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.lesson_plans_id_seq', 1, true);


--
-- Name: library_members_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.library_members_id_seq', 1, false);


--
-- Name: marks_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.marks_id_seq', 60, true);


--
-- Name: materials_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.materials_id_seq', 1, true);


--
-- Name: mess_menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.mess_menu_id_seq', 1, false);


--
-- Name: messages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.messages_id_seq', 21, true);


--
-- Name: notifications_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.notifications_id_seq', 23, true);


--
-- Name: otp_resets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.otp_resets_id_seq', 1, false);


--
-- Name: payroll_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.payroll_id_seq', 22, true);


--
-- Name: purchase_order_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.purchase_order_items_id_seq', 1, false);


--
-- Name: purchase_orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.purchase_orders_id_seq', 5, true);


--
-- Name: question_bank_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.question_bank_id_seq', 13, true);


--
-- Name: quiz_attempts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.quiz_attempts_id_seq', 1, false);


--
-- Name: quiz_questions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.quiz_questions_id_seq', 3, true);


--
-- Name: quizzes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.quizzes_id_seq', 5, true);


--
-- Name: recruitment_positions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.recruitment_positions_id_seq', 6, true);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.roles_id_seq', 59, true);


--
-- Name: route_stops_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.route_stops_id_seq', 1, false);


--
-- Name: routes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.routes_id_seq', 13, true);


--
-- Name: sms_logs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.sms_logs_id_seq', 1, false);


--
-- Name: staff_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.staff_id_seq', 16, true);


--
-- Name: students_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.students_id_seq', 44, true);


--
-- Name: subjects_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.subjects_id_seq', 49, true);


--
-- Name: suppliers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.suppliers_id_seq', 5, true);


--
-- Name: support_messages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.support_messages_id_seq', 21, true);


--
-- Name: syllabuses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.syllabuses_id_seq', 1, true);


--
-- Name: system_settings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.system_settings_id_seq', 1, false);


--
-- Name: timetables_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.timetables_id_seq', 9, true);


--
-- Name: transport_assignments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.transport_assignments_id_seq', 1, false);


--
-- Name: user_roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.user_roles_id_seq', 24, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.users_id_seq', 73, true);


--
-- Name: vehicle_maintenance_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.vehicle_maintenance_id_seq', 1, false);


--
-- Name: vehicles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: neondb_owner
--

SELECT pg_catalog.setval('public.vehicles_id_seq', 5, true);


--
-- Name: academic_calendar academic_calendar_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.academic_calendar
    ADD CONSTRAINT academic_calendar_pkey PRIMARY KEY (id);


--
-- Name: admissions admissions_application_number_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.admissions
    ADD CONSTRAINT admissions_application_number_key UNIQUE (application_number);


--
-- Name: admissions admissions_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.admissions
    ADD CONSTRAINT admissions_pkey PRIMARY KEY (id);


--
-- Name: announcements announcements_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.announcements
    ADD CONSTRAINT announcements_pkey PRIMARY KEY (id);


--
-- Name: assets assets_asset_code_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assets
    ADD CONSTRAINT assets_asset_code_key UNIQUE (asset_code);


--
-- Name: assets assets_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assets
    ADD CONSTRAINT assets_pkey PRIMARY KEY (id);


--
-- Name: assignment_submissions assignment_submissions_assignment_id_student_id_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assignment_submissions
    ADD CONSTRAINT assignment_submissions_assignment_id_student_id_key UNIQUE (assignment_id, student_id);


--
-- Name: assignment_submissions assignment_submissions_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assignment_submissions
    ADD CONSTRAINT assignment_submissions_pkey PRIMARY KEY (id);


--
-- Name: assignments assignments_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assignments
    ADD CONSTRAINT assignments_pkey PRIMARY KEY (id);


--
-- Name: attendance attendance_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.attendance
    ADD CONSTRAINT attendance_pkey PRIMARY KEY (id);


--
-- Name: audit_logs audit_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.audit_logs
    ADD CONSTRAINT audit_logs_pkey PRIMARY KEY (id);


--
-- Name: book_issues book_issues_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.book_issues
    ADD CONSTRAINT book_issues_pkey PRIMARY KEY (id);


--
-- Name: books books_isbn_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.books
    ADD CONSTRAINT books_isbn_key UNIQUE (isbn);


--
-- Name: books books_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.books
    ADD CONSTRAINT books_pkey PRIMARY KEY (id);


--
-- Name: budget budget_budget_number_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.budget
    ADD CONSTRAINT budget_budget_number_key UNIQUE (budget_number);


--
-- Name: budget budget_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.budget
    ADD CONSTRAINT budget_pkey PRIMARY KEY (id);


--
-- Name: budgets budgets_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.budgets
    ADD CONSTRAINT budgets_pkey PRIMARY KEY (id);


--
-- Name: calendar_events calendar_events_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.calendar_events
    ADD CONSTRAINT calendar_events_pkey PRIMARY KEY (id);


--
-- Name: classes classes_code_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.classes
    ADD CONSTRAINT classes_code_key UNIQUE (code);


--
-- Name: classes classes_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.classes
    ADD CONSTRAINT classes_pkey PRIMARY KEY (id);


--
-- Name: courses courses_code_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT courses_code_key UNIQUE (code);


--
-- Name: courses courses_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.courses
    ADD CONSTRAINT courses_pkey PRIMARY KEY (id);


--
-- Name: database_backups database_backups_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.database_backups
    ADD CONSTRAINT database_backups_pkey PRIMARY KEY (id);


--
-- Name: departments departments_code_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT departments_code_key UNIQUE (code);


--
-- Name: departments departments_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT departments_pkey PRIMARY KEY (id);


--
-- Name: email_logs email_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.email_logs
    ADD CONSTRAINT email_logs_pkey PRIMARY KEY (id);


--
-- Name: exams exams_code_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.exams
    ADD CONSTRAINT exams_code_key UNIQUE (code);


--
-- Name: exams exams_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.exams
    ADD CONSTRAINT exams_pkey PRIMARY KEY (id);


--
-- Name: expenses expenses_expense_number_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.expenses
    ADD CONSTRAINT expenses_expense_number_key UNIQUE (expense_number);


--
-- Name: expenses expenses_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.expenses
    ADD CONSTRAINT expenses_pkey PRIMARY KEY (id);


--
-- Name: fee_structure_templates fee_structure_templates_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.fee_structure_templates
    ADD CONSTRAINT fee_structure_templates_pkey PRIMARY KEY (id);


--
-- Name: fees_structures fees_structures_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.fees_structures
    ADD CONSTRAINT fees_structures_pkey PRIMARY KEY (id);


--
-- Name: forum_posts forum_posts_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.forum_posts
    ADD CONSTRAINT forum_posts_pkey PRIMARY KEY (id);


--
-- Name: forums forums_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.forums
    ADD CONSTRAINT forums_pkey PRIMARY KEY (id);


--
-- Name: holidays holidays_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.holidays
    ADD CONSTRAINT holidays_pkey PRIMARY KEY (id);


--
-- Name: hostel_complaints hostel_complaints_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_complaints
    ADD CONSTRAINT hostel_complaints_pkey PRIMARY KEY (id);


--
-- Name: hostel_residents hostel_residents_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_residents
    ADD CONSTRAINT hostel_residents_pkey PRIMARY KEY (id);


--
-- Name: hostel_rooms hostel_rooms_hostel_id_room_number_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_rooms
    ADD CONSTRAINT hostel_rooms_hostel_id_room_number_key UNIQUE (hostel_id, room_number);


--
-- Name: hostel_rooms hostel_rooms_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_rooms
    ADD CONSTRAINT hostel_rooms_pkey PRIMARY KEY (id);


--
-- Name: hostel_visitors hostel_visitors_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_visitors
    ADD CONSTRAINT hostel_visitors_pkey PRIMARY KEY (id);


--
-- Name: hostels hostels_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostels
    ADD CONSTRAINT hostels_pkey PRIMARY KEY (id);


--
-- Name: hr_events hr_events_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hr_events
    ADD CONSTRAINT hr_events_pkey PRIMARY KEY (id);


--
-- Name: integrations integrations_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.integrations
    ADD CONSTRAINT integrations_pkey PRIMARY KEY (id);


--
-- Name: inventory_items inventory_items_item_code_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.inventory_items
    ADD CONSTRAINT inventory_items_item_code_key UNIQUE (item_code);


--
-- Name: inventory_items inventory_items_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.inventory_items
    ADD CONSTRAINT inventory_items_pkey PRIMARY KEY (id);


--
-- Name: invoices invoices_invoice_number_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.invoices
    ADD CONSTRAINT invoices_invoice_number_key UNIQUE (invoice_number);


--
-- Name: invoices invoices_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.invoices
    ADD CONSTRAINT invoices_pkey PRIMARY KEY (id);


--
-- Name: leave_applications leave_applications_application_number_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leave_applications
    ADD CONSTRAINT leave_applications_application_number_key UNIQUE (application_number);


--
-- Name: leave_applications leave_applications_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leave_applications
    ADD CONSTRAINT leave_applications_pkey PRIMARY KEY (id);


--
-- Name: leave_balances leave_balances_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leave_balances
    ADD CONSTRAINT leave_balances_pkey PRIMARY KEY (id);


--
-- Name: leave_balances leave_balances_user_id_leave_type_id_year_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leave_balances
    ADD CONSTRAINT leave_balances_user_id_leave_type_id_year_key UNIQUE (user_id, leave_type_id, year);


--
-- Name: leave_types leave_types_code_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leave_types
    ADD CONSTRAINT leave_types_code_key UNIQUE (code);


--
-- Name: leave_types leave_types_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leave_types
    ADD CONSTRAINT leave_types_pkey PRIMARY KEY (id);


--
-- Name: leaves leaves_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leaves
    ADD CONSTRAINT leaves_pkey PRIMARY KEY (id);


--
-- Name: lesson_plans lesson_plans_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.lesson_plans
    ADD CONSTRAINT lesson_plans_pkey PRIMARY KEY (id);


--
-- Name: library_members library_members_member_number_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.library_members
    ADD CONSTRAINT library_members_member_number_key UNIQUE (member_number);


--
-- Name: library_members library_members_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.library_members
    ADD CONSTRAINT library_members_pkey PRIMARY KEY (id);


--
-- Name: marks marks_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.marks
    ADD CONSTRAINT marks_pkey PRIMARY KEY (id);


--
-- Name: materials materials_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.materials
    ADD CONSTRAINT materials_pkey PRIMARY KEY (id);


--
-- Name: mess_menu mess_menu_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.mess_menu
    ADD CONSTRAINT mess_menu_pkey PRIMARY KEY (id);


--
-- Name: messages messages_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.messages
    ADD CONSTRAINT messages_pkey PRIMARY KEY (id);


--
-- Name: notifications notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_pkey PRIMARY KEY (id);


--
-- Name: otp_resets otp_resets_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.otp_resets
    ADD CONSTRAINT otp_resets_pkey PRIMARY KEY (id);


--
-- Name: payroll payroll_payroll_number_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.payroll
    ADD CONSTRAINT payroll_payroll_number_key UNIQUE (payroll_number);


--
-- Name: payroll payroll_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.payroll
    ADD CONSTRAINT payroll_pkey PRIMARY KEY (id);


--
-- Name: payroll payroll_staff_id_month_year_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.payroll
    ADD CONSTRAINT payroll_staff_id_month_year_key UNIQUE (staff_id, month, year);


--
-- Name: purchase_order_items purchase_order_items_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.purchase_order_items
    ADD CONSTRAINT purchase_order_items_pkey PRIMARY KEY (id);


--
-- Name: purchase_orders purchase_orders_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.purchase_orders
    ADD CONSTRAINT purchase_orders_pkey PRIMARY KEY (id);


--
-- Name: purchase_orders purchase_orders_po_number_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.purchase_orders
    ADD CONSTRAINT purchase_orders_po_number_key UNIQUE (po_number);


--
-- Name: question_bank question_bank_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.question_bank
    ADD CONSTRAINT question_bank_pkey PRIMARY KEY (id);


--
-- Name: quiz_attempts quiz_attempts_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.quiz_attempts
    ADD CONSTRAINT quiz_attempts_pkey PRIMARY KEY (id);


--
-- Name: quiz_questions quiz_questions_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.quiz_questions
    ADD CONSTRAINT quiz_questions_pkey PRIMARY KEY (id);


--
-- Name: quizzes quizzes_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.quizzes
    ADD CONSTRAINT quizzes_pkey PRIMARY KEY (id);


--
-- Name: recruitment_positions recruitment_positions_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.recruitment_positions
    ADD CONSTRAINT recruitment_positions_pkey PRIMARY KEY (id);


--
-- Name: roles roles_name_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_key UNIQUE (name);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: route_stops route_stops_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.route_stops
    ADD CONSTRAINT route_stops_pkey PRIMARY KEY (id);


--
-- Name: routes routes_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.routes
    ADD CONSTRAINT routes_pkey PRIMARY KEY (id);


--
-- Name: routes routes_route_number_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.routes
    ADD CONSTRAINT routes_route_number_key UNIQUE (route_number);


--
-- Name: sms_logs sms_logs_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.sms_logs
    ADD CONSTRAINT sms_logs_pkey PRIMARY KEY (id);


--
-- Name: staff staff_employee_id_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT staff_employee_id_key UNIQUE (employee_id);


--
-- Name: staff staff_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT staff_pkey PRIMARY KEY (id);


--
-- Name: students students_admission_number_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT students_admission_number_key UNIQUE (admission_number);


--
-- Name: students students_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT students_pkey PRIMARY KEY (id);


--
-- Name: subjects subjects_code_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.subjects
    ADD CONSTRAINT subjects_code_key UNIQUE (code);


--
-- Name: subjects subjects_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.subjects
    ADD CONSTRAINT subjects_pkey PRIMARY KEY (id);


--
-- Name: suppliers suppliers_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.suppliers
    ADD CONSTRAINT suppliers_pkey PRIMARY KEY (id);


--
-- Name: suppliers suppliers_supplier_code_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.suppliers
    ADD CONSTRAINT suppliers_supplier_code_key UNIQUE (supplier_code);


--
-- Name: support_messages support_messages_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.support_messages
    ADD CONSTRAINT support_messages_pkey PRIMARY KEY (id);


--
-- Name: syllabuses syllabuses_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.syllabuses
    ADD CONSTRAINT syllabuses_pkey PRIMARY KEY (id);


--
-- Name: system_settings system_settings_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.system_settings
    ADD CONSTRAINT system_settings_pkey PRIMARY KEY (id);


--
-- Name: system_settings system_settings_setting_key_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.system_settings
    ADD CONSTRAINT system_settings_setting_key_key UNIQUE (setting_key);


--
-- Name: timetables timetables_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.timetables
    ADD CONSTRAINT timetables_pkey PRIMARY KEY (id);


--
-- Name: transport_assignments transport_assignments_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.transport_assignments
    ADD CONSTRAINT transport_assignments_pkey PRIMARY KEY (id);


--
-- Name: attendance unique_attendance; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.attendance
    ADD CONSTRAINT unique_attendance UNIQUE (student_id, class_id, subject_id, date, period);


--
-- Name: marks unique_mark; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.marks
    ADD CONSTRAINT unique_mark UNIQUE (student_id, exam_id, subject_id);


--
-- Name: user_roles unique_user_role; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.user_roles
    ADD CONSTRAINT unique_user_role UNIQUE (user_id, role_id);


--
-- Name: user_roles user_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.user_roles
    ADD CONSTRAINT user_roles_pkey PRIMARY KEY (id);


--
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: vehicle_maintenance vehicle_maintenance_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.vehicle_maintenance
    ADD CONSTRAINT vehicle_maintenance_pkey PRIMARY KEY (id);


--
-- Name: vehicles vehicles_pkey; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.vehicles
    ADD CONSTRAINT vehicles_pkey PRIMARY KEY (id);


--
-- Name: vehicles vehicles_vehicle_number_key; Type: CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.vehicles
    ADD CONSTRAINT vehicles_vehicle_number_key UNIQUE (vehicle_number);


--
-- Name: idx_budget_academic_year; Type: INDEX; Schema: public; Owner: neondb_owner
--

CREATE INDEX idx_budget_academic_year ON public.budget USING btree (academic_year);


--
-- Name: idx_budget_category; Type: INDEX; Schema: public; Owner: neondb_owner
--

CREATE INDEX idx_budget_category ON public.budget USING btree (category);


--
-- Name: idx_budget_status; Type: INDEX; Schema: public; Owner: neondb_owner
--

CREATE INDEX idx_budget_status ON public.budget USING btree (status);


--
-- Name: admissions trigger_update_admissions_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_admissions_updated_at BEFORE UPDATE ON public.admissions FOR EACH ROW EXECUTE FUNCTION public.update_admissions_updated_at();


--
-- Name: announcements trigger_update_announcements_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_announcements_updated_at BEFORE UPDATE ON public.announcements FOR EACH ROW EXECUTE FUNCTION public.update_announcements_updated_at();


--
-- Name: assets trigger_update_assets_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_assets_updated_at BEFORE UPDATE ON public.assets FOR EACH ROW EXECUTE FUNCTION public.update_assets_updated_at();


--
-- Name: assignments trigger_update_assignments_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_assignments_updated_at BEFORE UPDATE ON public.assignments FOR EACH ROW EXECUTE FUNCTION public.update_assignments_updated_at();


--
-- Name: attendance trigger_update_attendance_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_attendance_updated_at BEFORE UPDATE ON public.attendance FOR EACH ROW EXECUTE FUNCTION public.update_attendance_updated_at();


--
-- Name: books trigger_update_books_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_books_updated_at BEFORE UPDATE ON public.books FOR EACH ROW EXECUTE FUNCTION public.update_books_updated_at();


--
-- Name: classes trigger_update_classes_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_classes_updated_at BEFORE UPDATE ON public.classes FOR EACH ROW EXECUTE FUNCTION public.update_classes_updated_at();


--
-- Name: courses trigger_update_courses_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_courses_updated_at BEFORE UPDATE ON public.courses FOR EACH ROW EXECUTE FUNCTION public.update_courses_updated_at();


--
-- Name: departments trigger_update_departments_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_departments_updated_at BEFORE UPDATE ON public.departments FOR EACH ROW EXECUTE FUNCTION public.update_departments_updated_at();


--
-- Name: exams trigger_update_exams_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_exams_updated_at BEFORE UPDATE ON public.exams FOR EACH ROW EXECUTE FUNCTION public.update_exams_updated_at();


--
-- Name: fee_structure_templates trigger_update_fee_structure_templates_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_fee_structure_templates_updated_at BEFORE UPDATE ON public.fee_structure_templates FOR EACH ROW EXECUTE FUNCTION public.update_fee_structure_templates_updated_at();


--
-- Name: fees_structures trigger_update_fees_structures_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_fees_structures_updated_at BEFORE UPDATE ON public.fees_structures FOR EACH ROW EXECUTE FUNCTION public.update_fees_structures_updated_at();


--
-- Name: hostels trigger_update_hostels_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_hostels_updated_at BEFORE UPDATE ON public.hostels FOR EACH ROW EXECUTE FUNCTION public.update_hostels_updated_at();


--
-- Name: invoices trigger_update_invoices_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_invoices_updated_at BEFORE UPDATE ON public.invoices FOR EACH ROW EXECUTE FUNCTION public.update_invoices_updated_at();


--
-- Name: leave_types trigger_update_leave_types_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_leave_types_updated_at BEFORE UPDATE ON public.leave_types FOR EACH ROW EXECUTE FUNCTION public.update_leave_types_updated_at();


--
-- Name: marks trigger_update_marks_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_marks_updated_at BEFORE UPDATE ON public.marks FOR EACH ROW EXECUTE FUNCTION public.update_marks_updated_at();


--
-- Name: materials trigger_update_materials_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_materials_updated_at BEFORE UPDATE ON public.materials FOR EACH ROW EXECUTE FUNCTION public.update_materials_updated_at();


--
-- Name: notifications trigger_update_notifications_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_notifications_updated_at BEFORE UPDATE ON public.notifications FOR EACH ROW EXECUTE FUNCTION public.update_notifications_updated_at();


--
-- Name: roles trigger_update_roles_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_roles_updated_at BEFORE UPDATE ON public.roles FOR EACH ROW EXECUTE FUNCTION public.update_roles_updated_at();


--
-- Name: staff trigger_update_staff_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_staff_updated_at BEFORE UPDATE ON public.staff FOR EACH ROW EXECUTE FUNCTION public.update_staff_updated_at();


--
-- Name: students trigger_update_students_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_students_updated_at BEFORE UPDATE ON public.students FOR EACH ROW EXECUTE FUNCTION public.update_students_updated_at();


--
-- Name: subjects trigger_update_subjects_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_subjects_updated_at BEFORE UPDATE ON public.subjects FOR EACH ROW EXECUTE FUNCTION public.update_subjects_updated_at();


--
-- Name: syllabuses trigger_update_syllabuses_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_syllabuses_updated_at BEFORE UPDATE ON public.syllabuses FOR EACH ROW EXECUTE FUNCTION public.update_syllabuses_updated_at();


--
-- Name: system_settings trigger_update_system_settings_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_system_settings_updated_at BEFORE UPDATE ON public.system_settings FOR EACH ROW EXECUTE FUNCTION public.update_system_settings_updated_at();


--
-- Name: timetables trigger_update_timetables_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_timetables_updated_at BEFORE UPDATE ON public.timetables FOR EACH ROW EXECUTE FUNCTION public.update_timetables_updated_at();


--
-- Name: user_roles trigger_update_user_roles_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_user_roles_updated_at BEFORE UPDATE ON public.user_roles FOR EACH ROW EXECUTE FUNCTION public.update_user_roles_updated_at();


--
-- Name: users trigger_update_users_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_users_updated_at BEFORE UPDATE ON public.users FOR EACH ROW EXECUTE FUNCTION public.update_users_updated_at();


--
-- Name: vehicles trigger_update_vehicles_updated_at; Type: TRIGGER; Schema: public; Owner: neondb_owner
--

CREATE TRIGGER trigger_update_vehicles_updated_at BEFORE UPDATE ON public.vehicles FOR EACH ROW EXECUTE FUNCTION public.update_vehicles_updated_at();


--
-- Name: admissions admissions_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.admissions
    ADD CONSTRAINT admissions_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE SET NULL;


--
-- Name: admissions admissions_course_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.admissions
    ADD CONSTRAINT admissions_course_id_fkey FOREIGN KEY (course_id) REFERENCES public.courses(id) ON DELETE SET NULL;


--
-- Name: admissions admissions_reviewed_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.admissions
    ADD CONSTRAINT admissions_reviewed_by_fkey FOREIGN KEY (reviewed_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: announcements announcements_published_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.announcements
    ADD CONSTRAINT announcements_published_by_fkey FOREIGN KEY (published_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: assets assets_assigned_to_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assets
    ADD CONSTRAINT assets_assigned_to_fkey FOREIGN KEY (assigned_to) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: assignment_submissions assignment_submissions_assignment_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assignment_submissions
    ADD CONSTRAINT assignment_submissions_assignment_id_fkey FOREIGN KEY (assignment_id) REFERENCES public.assignments(id) ON DELETE CASCADE;


--
-- Name: assignment_submissions assignment_submissions_graded_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assignment_submissions
    ADD CONSTRAINT assignment_submissions_graded_by_fkey FOREIGN KEY (graded_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: assignment_submissions assignment_submissions_student_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assignment_submissions
    ADD CONSTRAINT assignment_submissions_student_id_fkey FOREIGN KEY (student_id) REFERENCES public.students(id) ON DELETE CASCADE;


--
-- Name: assignments assignments_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assignments
    ADD CONSTRAINT assignments_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE CASCADE;


--
-- Name: assignments assignments_subject_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assignments
    ADD CONSTRAINT assignments_subject_id_fkey FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE CASCADE;


--
-- Name: assignments assignments_teacher_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.assignments
    ADD CONSTRAINT assignments_teacher_id_fkey FOREIGN KEY (teacher_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: attendance attendance_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.attendance
    ADD CONSTRAINT attendance_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE CASCADE;


--
-- Name: attendance attendance_marked_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.attendance
    ADD CONSTRAINT attendance_marked_by_fkey FOREIGN KEY (marked_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: attendance attendance_student_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.attendance
    ADD CONSTRAINT attendance_student_id_fkey FOREIGN KEY (student_id) REFERENCES public.students(id) ON DELETE CASCADE;


--
-- Name: attendance attendance_subject_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.attendance
    ADD CONSTRAINT attendance_subject_id_fkey FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE SET NULL;


--
-- Name: audit_logs audit_logs_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.audit_logs
    ADD CONSTRAINT audit_logs_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: book_issues book_issues_book_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.book_issues
    ADD CONSTRAINT book_issues_book_id_fkey FOREIGN KEY (book_id) REFERENCES public.books(id) ON DELETE CASCADE;


--
-- Name: book_issues book_issues_issued_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.book_issues
    ADD CONSTRAINT book_issues_issued_by_fkey FOREIGN KEY (issued_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: book_issues book_issues_returned_to_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.book_issues
    ADD CONSTRAINT book_issues_returned_to_fkey FOREIGN KEY (returned_to) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: book_issues book_issues_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.book_issues
    ADD CONSTRAINT book_issues_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: budget budget_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.budget
    ADD CONSTRAINT budget_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: calendar_events calendar_events_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.calendar_events
    ADD CONSTRAINT calendar_events_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: classes classes_course_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.classes
    ADD CONSTRAINT classes_course_id_fkey FOREIGN KEY (course_id) REFERENCES public.courses(id) ON DELETE SET NULL;


--
-- Name: database_backups database_backups_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.database_backups
    ADD CONSTRAINT database_backups_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: departments departments_head_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT departments_head_id_fkey FOREIGN KEY (head_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: departments departments_parent_department_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT departments_parent_department_id_fkey FOREIGN KEY (parent_department_id) REFERENCES public.departments(id) ON DELETE SET NULL;


--
-- Name: email_logs email_logs_sent_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.email_logs
    ADD CONSTRAINT email_logs_sent_by_fkey FOREIGN KEY (sent_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: exams exams_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.exams
    ADD CONSTRAINT exams_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE SET NULL;


--
-- Name: expenses expenses_approved_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.expenses
    ADD CONSTRAINT expenses_approved_by_fkey FOREIGN KEY (approved_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: expenses expenses_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.expenses
    ADD CONSTRAINT expenses_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: fee_structure_templates fee_structure_templates_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.fee_structure_templates
    ADD CONSTRAINT fee_structure_templates_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE SET NULL;


--
-- Name: fees_structures fees_structures_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.fees_structures
    ADD CONSTRAINT fees_structures_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE SET NULL;


--
-- Name: fees_structures fees_structures_course_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.fees_structures
    ADD CONSTRAINT fees_structures_course_id_fkey FOREIGN KEY (course_id) REFERENCES public.courses(id) ON DELETE SET NULL;


--
-- Name: staff fk_staff_department; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT fk_staff_department FOREIGN KEY (department_id) REFERENCES public.departments(id) ON DELETE SET NULL;


--
-- Name: forum_posts forum_posts_forum_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.forum_posts
    ADD CONSTRAINT forum_posts_forum_id_fkey FOREIGN KEY (forum_id) REFERENCES public.forums(id) ON DELETE CASCADE;


--
-- Name: forum_posts forum_posts_parent_post_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.forum_posts
    ADD CONSTRAINT forum_posts_parent_post_id_fkey FOREIGN KEY (parent_post_id) REFERENCES public.forum_posts(id) ON DELETE CASCADE;


--
-- Name: forum_posts forum_posts_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.forum_posts
    ADD CONSTRAINT forum_posts_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: forums forums_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.forums
    ADD CONSTRAINT forums_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE SET NULL;


--
-- Name: forums forums_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.forums
    ADD CONSTRAINT forums_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: forums forums_subject_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.forums
    ADD CONSTRAINT forums_subject_id_fkey FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE SET NULL;


--
-- Name: holidays holidays_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.holidays
    ADD CONSTRAINT holidays_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: hostel_complaints hostel_complaints_assigned_to_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_complaints
    ADD CONSTRAINT hostel_complaints_assigned_to_fkey FOREIGN KEY (assigned_to) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: hostel_complaints hostel_complaints_hostel_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_complaints
    ADD CONSTRAINT hostel_complaints_hostel_id_fkey FOREIGN KEY (hostel_id) REFERENCES public.hostels(id) ON DELETE CASCADE;


--
-- Name: hostel_complaints hostel_complaints_resident_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_complaints
    ADD CONSTRAINT hostel_complaints_resident_id_fkey FOREIGN KEY (resident_id) REFERENCES public.hostel_residents(id) ON DELETE CASCADE;


--
-- Name: hostel_residents hostel_residents_hostel_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_residents
    ADD CONSTRAINT hostel_residents_hostel_id_fkey FOREIGN KEY (hostel_id) REFERENCES public.hostels(id) ON DELETE CASCADE;


--
-- Name: hostel_residents hostel_residents_room_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_residents
    ADD CONSTRAINT hostel_residents_room_id_fkey FOREIGN KEY (room_id) REFERENCES public.hostel_rooms(id) ON DELETE CASCADE;


--
-- Name: hostel_residents hostel_residents_student_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_residents
    ADD CONSTRAINT hostel_residents_student_id_fkey FOREIGN KEY (student_id) REFERENCES public.students(id) ON DELETE CASCADE;


--
-- Name: hostel_rooms hostel_rooms_hostel_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_rooms
    ADD CONSTRAINT hostel_rooms_hostel_id_fkey FOREIGN KEY (hostel_id) REFERENCES public.hostels(id) ON DELETE CASCADE;


--
-- Name: hostel_visitors hostel_visitors_approved_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_visitors
    ADD CONSTRAINT hostel_visitors_approved_by_fkey FOREIGN KEY (approved_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: hostel_visitors hostel_visitors_resident_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostel_visitors
    ADD CONSTRAINT hostel_visitors_resident_id_fkey FOREIGN KEY (resident_id) REFERENCES public.hostel_residents(id) ON DELETE CASCADE;


--
-- Name: hostels hostels_warden_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hostels
    ADD CONSTRAINT hostels_warden_id_fkey FOREIGN KEY (warden_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: hr_events hr_events_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.hr_events
    ADD CONSTRAINT hr_events_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: invoices invoices_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.invoices
    ADD CONSTRAINT invoices_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: invoices invoices_fee_structure_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.invoices
    ADD CONSTRAINT invoices_fee_structure_id_fkey FOREIGN KEY (fee_structure_id) REFERENCES public.fees_structures(id) ON DELETE SET NULL;


--
-- Name: invoices invoices_student_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.invoices
    ADD CONSTRAINT invoices_student_id_fkey FOREIGN KEY (student_id) REFERENCES public.students(id) ON DELETE CASCADE;


--
-- Name: leave_applications leave_applications_leave_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leave_applications
    ADD CONSTRAINT leave_applications_leave_type_id_fkey FOREIGN KEY (leave_type_id) REFERENCES public.leave_types(id) ON DELETE CASCADE;


--
-- Name: leave_applications leave_applications_reviewed_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leave_applications
    ADD CONSTRAINT leave_applications_reviewed_by_fkey FOREIGN KEY (reviewed_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: leave_applications leave_applications_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leave_applications
    ADD CONSTRAINT leave_applications_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: leave_balances leave_balances_leave_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leave_balances
    ADD CONSTRAINT leave_balances_leave_type_id_fkey FOREIGN KEY (leave_type_id) REFERENCES public.leave_types(id) ON DELETE CASCADE;


--
-- Name: leave_balances leave_balances_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leave_balances
    ADD CONSTRAINT leave_balances_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: leaves leaves_approved_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leaves
    ADD CONSTRAINT leaves_approved_by_fkey FOREIGN KEY (approved_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: leaves leaves_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.leaves
    ADD CONSTRAINT leaves_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: lesson_plans lesson_plans_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.lesson_plans
    ADD CONSTRAINT lesson_plans_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE SET NULL;


--
-- Name: lesson_plans lesson_plans_subject_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.lesson_plans
    ADD CONSTRAINT lesson_plans_subject_id_fkey FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE SET NULL;


--
-- Name: library_members library_members_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.library_members
    ADD CONSTRAINT library_members_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: marks marks_entered_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.marks
    ADD CONSTRAINT marks_entered_by_fkey FOREIGN KEY (entered_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: marks marks_exam_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.marks
    ADD CONSTRAINT marks_exam_id_fkey FOREIGN KEY (exam_id) REFERENCES public.exams(id) ON DELETE CASCADE;


--
-- Name: marks marks_student_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.marks
    ADD CONSTRAINT marks_student_id_fkey FOREIGN KEY (student_id) REFERENCES public.students(id) ON DELETE CASCADE;


--
-- Name: marks marks_subject_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.marks
    ADD CONSTRAINT marks_subject_id_fkey FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE CASCADE;


--
-- Name: materials materials_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.materials
    ADD CONSTRAINT materials_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE SET NULL;


--
-- Name: materials materials_subject_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.materials
    ADD CONSTRAINT materials_subject_id_fkey FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE SET NULL;


--
-- Name: materials materials_uploaded_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.materials
    ADD CONSTRAINT materials_uploaded_by_fkey FOREIGN KEY (uploaded_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: mess_menu mess_menu_hostel_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.mess_menu
    ADD CONSTRAINT mess_menu_hostel_id_fkey FOREIGN KEY (hostel_id) REFERENCES public.hostels(id) ON DELETE CASCADE;


--
-- Name: messages messages_parent_message_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.messages
    ADD CONSTRAINT messages_parent_message_id_fkey FOREIGN KEY (parent_message_id) REFERENCES public.messages(id) ON DELETE SET NULL;


--
-- Name: messages messages_receiver_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.messages
    ADD CONSTRAINT messages_receiver_id_fkey FOREIGN KEY (receiver_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: messages messages_sender_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.messages
    ADD CONSTRAINT messages_sender_id_fkey FOREIGN KEY (sender_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: notifications notifications_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.notifications
    ADD CONSTRAINT notifications_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: payroll payroll_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.payroll
    ADD CONSTRAINT payroll_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: payroll payroll_staff_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.payroll
    ADD CONSTRAINT payroll_staff_id_fkey FOREIGN KEY (staff_id) REFERENCES public.staff(id) ON DELETE CASCADE;


--
-- Name: purchase_order_items purchase_order_items_item_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.purchase_order_items
    ADD CONSTRAINT purchase_order_items_item_id_fkey FOREIGN KEY (item_id) REFERENCES public.inventory_items(id) ON DELETE CASCADE;


--
-- Name: purchase_order_items purchase_order_items_po_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.purchase_order_items
    ADD CONSTRAINT purchase_order_items_po_id_fkey FOREIGN KEY (po_id) REFERENCES public.purchase_orders(id) ON DELETE CASCADE;


--
-- Name: purchase_orders purchase_orders_approved_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.purchase_orders
    ADD CONSTRAINT purchase_orders_approved_by_fkey FOREIGN KEY (approved_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: purchase_orders purchase_orders_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.purchase_orders
    ADD CONSTRAINT purchase_orders_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: purchase_orders purchase_orders_supplier_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.purchase_orders
    ADD CONSTRAINT purchase_orders_supplier_id_fkey FOREIGN KEY (supplier_id) REFERENCES public.suppliers(id) ON DELETE CASCADE;


--
-- Name: question_bank question_bank_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.question_bank
    ADD CONSTRAINT question_bank_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE SET NULL;


--
-- Name: question_bank question_bank_subject_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.question_bank
    ADD CONSTRAINT question_bank_subject_id_fkey FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE SET NULL;


--
-- Name: quiz_attempts quiz_attempts_quiz_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.quiz_attempts
    ADD CONSTRAINT quiz_attempts_quiz_id_fkey FOREIGN KEY (quiz_id) REFERENCES public.quizzes(id) ON DELETE CASCADE;


--
-- Name: quiz_attempts quiz_attempts_student_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.quiz_attempts
    ADD CONSTRAINT quiz_attempts_student_id_fkey FOREIGN KEY (student_id) REFERENCES public.students(id) ON DELETE CASCADE;


--
-- Name: quiz_questions quiz_questions_quiz_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.quiz_questions
    ADD CONSTRAINT quiz_questions_quiz_id_fkey FOREIGN KEY (quiz_id) REFERENCES public.quizzes(id) ON DELETE CASCADE;


--
-- Name: quizzes quizzes_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.quizzes
    ADD CONSTRAINT quizzes_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE CASCADE;


--
-- Name: quizzes quizzes_subject_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.quizzes
    ADD CONSTRAINT quizzes_subject_id_fkey FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE CASCADE;


--
-- Name: quizzes quizzes_teacher_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.quizzes
    ADD CONSTRAINT quizzes_teacher_id_fkey FOREIGN KEY (teacher_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: recruitment_positions recruitment_positions_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.recruitment_positions
    ADD CONSTRAINT recruitment_positions_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: route_stops route_stops_route_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.route_stops
    ADD CONSTRAINT route_stops_route_id_fkey FOREIGN KEY (route_id) REFERENCES public.routes(id) ON DELETE CASCADE;


--
-- Name: routes routes_driver_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.routes
    ADD CONSTRAINT routes_driver_id_fkey FOREIGN KEY (driver_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: routes routes_vehicle_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.routes
    ADD CONSTRAINT routes_vehicle_id_fkey FOREIGN KEY (vehicle_id) REFERENCES public.vehicles(id) ON DELETE SET NULL;


--
-- Name: sms_logs sms_logs_sent_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.sms_logs
    ADD CONSTRAINT sms_logs_sent_by_fkey FOREIGN KEY (sent_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: staff staff_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.staff
    ADD CONSTRAINT staff_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: students students_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT students_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE SET NULL;


--
-- Name: students students_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT students_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: subjects subjects_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.subjects
    ADD CONSTRAINT subjects_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE SET NULL;


--
-- Name: subjects subjects_course_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.subjects
    ADD CONSTRAINT subjects_course_id_fkey FOREIGN KEY (course_id) REFERENCES public.courses(id) ON DELETE SET NULL;


--
-- Name: subjects subjects_teacher_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.subjects
    ADD CONSTRAINT subjects_teacher_id_fkey FOREIGN KEY (teacher_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: support_messages support_messages_admin_replied_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.support_messages
    ADD CONSTRAINT support_messages_admin_replied_by_fkey FOREIGN KEY (admin_replied_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: support_messages support_messages_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.support_messages
    ADD CONSTRAINT support_messages_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: syllabuses syllabuses_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.syllabuses
    ADD CONSTRAINT syllabuses_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE CASCADE;


--
-- Name: syllabuses syllabuses_created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.syllabuses
    ADD CONSTRAINT syllabuses_created_by_fkey FOREIGN KEY (created_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: syllabuses syllabuses_subject_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.syllabuses
    ADD CONSTRAINT syllabuses_subject_id_fkey FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE CASCADE;


--
-- Name: timetables timetables_class_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.timetables
    ADD CONSTRAINT timetables_class_id_fkey FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE CASCADE;


--
-- Name: timetables timetables_subject_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.timetables
    ADD CONSTRAINT timetables_subject_id_fkey FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE CASCADE;


--
-- Name: timetables timetables_teacher_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.timetables
    ADD CONSTRAINT timetables_teacher_id_fkey FOREIGN KEY (teacher_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: transport_assignments transport_assignments_route_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.transport_assignments
    ADD CONSTRAINT transport_assignments_route_id_fkey FOREIGN KEY (route_id) REFERENCES public.routes(id) ON DELETE CASCADE;


--
-- Name: transport_assignments transport_assignments_stop_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.transport_assignments
    ADD CONSTRAINT transport_assignments_stop_id_fkey FOREIGN KEY (stop_id) REFERENCES public.route_stops(id) ON DELETE SET NULL;


--
-- Name: transport_assignments transport_assignments_student_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.transport_assignments
    ADD CONSTRAINT transport_assignments_student_id_fkey FOREIGN KEY (student_id) REFERENCES public.students(id) ON DELETE CASCADE;


--
-- Name: user_roles user_roles_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.user_roles
    ADD CONSTRAINT user_roles_role_id_fkey FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: user_roles user_roles_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.user_roles
    ADD CONSTRAINT user_roles_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: vehicle_maintenance vehicle_maintenance_vehicle_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: neondb_owner
--

ALTER TABLE ONLY public.vehicle_maintenance
    ADD CONSTRAINT vehicle_maintenance_vehicle_id_fkey FOREIGN KEY (vehicle_id) REFERENCES public.vehicles(id) ON DELETE CASCADE;


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: neondb_owner
--

REVOKE USAGE ON SCHEMA public FROM PUBLIC;


--
-- Name: DEFAULT PRIVILEGES FOR SEQUENCES; Type: DEFAULT ACL; Schema: public; Owner: cloud_admin
--

ALTER DEFAULT PRIVILEGES FOR ROLE cloud_admin IN SCHEMA public GRANT ALL ON SEQUENCES TO neon_superuser WITH GRANT OPTION;


--
-- Name: DEFAULT PRIVILEGES FOR TABLES; Type: DEFAULT ACL; Schema: public; Owner: cloud_admin
--

ALTER DEFAULT PRIVILEGES FOR ROLE cloud_admin IN SCHEMA public GRANT ALL ON TABLES TO neon_superuser WITH GRANT OPTION;


--
-- PostgreSQL database dump complete
--

\unrestrict G8Vs48tWb9Dk9v2SZIaIxPY7NKZ2m5wscEJfYuqtKthMlu3c2PYDGhkncvmZ33a

